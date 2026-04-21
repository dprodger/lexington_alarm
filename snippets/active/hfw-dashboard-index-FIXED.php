<?php
/**
 * Hanscom Flight Watch - Public Dashboard
 * Location: /home1/ozpxkamy/public_html/hfw-dashboard/index.php
 * 
 * Updated: Simple ground time bar with markers
 * - Green: 0-45 min
 * - Yellow: 45+ min  
 * - Bar max: 2 hours
 * - Markers at: 45m, 1h, 1h15m, 1h30m
 * 
 * FIX: Jan 18, 2026 - Added flight_date to group_key to prevent
 * future flights on different dates from being merged into single card
 */

// Set timezone to Eastern for consistent time calculations
date_default_timezone_set('America/New_York');

require_once('functions.php');

// Ground time thresholds (in minutes)
define('GROUND_YELLOW_THRESHOLD', 45);  // Green -> Yellow after 45 min
define('GROUND_BAR_MAX', 120);           // 2 hours = 100% of progress bar

// Handle date/range parameters
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$view_mode = 'today';
$view_date = $today;
$view_range = 1;
$display_title = date('l, F j, Y');

if (isset($_GET['range']) && intval($_GET['range']) > 1) {
    $view_mode = 'past_range';
    $view_range = min(intval($_GET['range']), 30);
    $view_date = $today;
    $display_title = 'Past ' . $view_range . ' Days';
} elseif (isset($_GET['future']) && intval($_GET['future']) > 1) {
    $view_mode = 'future_range';
    $view_range = min(intval($_GET['future']), 30);
    $view_date = $today;
    $display_title = 'Next ' . $view_range . ' Days';
} elseif (isset($_GET['date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['date'])) {
    $view_mode = 'date';
    $view_date = $_GET['date'];
    $view_range = 1;
    $date_obj = DateTime::createFromFormat('Y-m-d', $view_date);
    if ($date_obj) {
        $display_title = $date_obj->format('l, F j, Y');
        if ($view_date === $today) {
            $view_mode = 'today';
        }
    }
}

// Fetch flights
if ($view_mode === 'future_range') {
    $raw_flights = hfw_get_flights_by_date($view_date, $view_range, null, 'future');
} else {
    $raw_flights = hfw_get_flights_by_date($view_date, $view_range, null, 'past');
}

// ============================================
// GROUP FLIGHTS BY TAIL NUMBER OR CALLSIGN
// FIX: Now includes flight_date in group_key to keep
// flights on different dates as separate cards
// ============================================
$grouped_flights = [];

foreach ($raw_flights as $record) {
    $tail = trim($record['tail_number'] ?? '');
    $carrier = trim($record['carrier'] ?? '');
    
    // Get the flight date for grouping (use flight_date, fallback to created_at date)
    $record_date = $record['flight_date'] ?? date('Y-m-d', strtotime($record['created_at']));
    
    // FIX: Include flight_date in group_key so flights on different dates stay separate
    if (!empty($tail)) {
        $group_key = 'tail:' . $tail . ':' . $record_date;
    } elseif (!empty($carrier)) {
        $origin = trim($record['origin'] ?? 'UNK');
        $group_key = 'callsign:' . $carrier . ':' . $origin . ':' . $record_date;
    } else {
        $group_key = 'id:' . $record['flight_id'];
    }
    
    if (!isset($grouped_flights[$group_key])) {
        $grouped_flights[$group_key] = [
            'group_key' => $group_key,
            'tail_number' => $tail,
            'carrier' => $carrier,
            'origin' => $record['origin'],
            'destination' => $record['destination'],
            'current_status' => $record['status'],
            'flight_ids' => [],
            'flight_date' => $record['flight_date'],
            'alert_at' => null,
            'alert_reason' => null,
            'confirmed_at' => null,
            'origin_departed_at' => null,
            'eta' => null,
            'landed_at' => null,
            'loading_at' => null,
            'departed_at' => null,
            'ground_time_minutes' => null,
            'created_at' => $record['created_at'],
            'updated_at' => $record['updated_at'],
        ];
    }
    
    $g = &$grouped_flights[$group_key];
    $g['flight_ids'][] = $record['flight_id'];
    
    if (empty($g['tail_number']) && !empty($tail)) {
        $g['tail_number'] = $tail;
    }
    if ((empty($g['carrier']) || $g['carrier'] === 'Unknown carrier') && !empty($carrier)) {
        $g['carrier'] = $carrier;
    }
    if (empty($g['alert_at']) && !empty($record['alert_at'])) {
        $g['alert_at'] = $record['alert_at'];
        $g['alert_reason'] = $record['alert_reason'];
    }
    if (empty($g['confirmed_at']) && !empty($record['confirmed_at'])) {
        $g['confirmed_at'] = $record['confirmed_at'];
    }
    if (empty($g['origin_departed_at']) && !empty($record['origin_departed_at'])) {
        $g['origin_departed_at'] = $record['origin_departed_at'];
    }
    if (empty($g['eta']) && !empty($record['eta'])) {
        $g['eta'] = $record['eta'];
    }
    if (empty($g['landed_at']) && !empty($record['landed_at'])) {
        $g['landed_at'] = $record['landed_at'];
    }
    if (empty($g['loading_at']) && !empty($record['loading_at'])) {
        $g['loading_at'] = $record['loading_at'];
    }
    if (empty($g['departed_at']) && !empty($record['departed_at'])) {
        $g['departed_at'] = $record['departed_at'];
    }
    if (empty($g['destination']) && !empty($record['destination'])) {
        $g['destination'] = $record['destination'];
    }
    if (empty($g['origin']) && !empty($record['origin'])) {
        $g['origin'] = $record['origin'];
    }
    if (empty($g['ground_time_minutes']) && !empty($record['ground_time_minutes'])) {
        $g['ground_time_minutes'] = $record['ground_time_minutes'];
    }
    // Update flight_date if not set
    if (empty($g['flight_date']) && !empty($record['flight_date'])) {
        $g['flight_date'] = $record['flight_date'];
    }
    
    $status_order = ['EXPECTED' => 1, 'INBOUND' => 2, 'ON_GROUND' => 3, 'LOADING' => 4, 'DEPARTED' => 5];
    $current_order = $status_order[$g['current_status']] ?? 0;
    $new_order = $status_order[$record['status']] ?? 0;
    if ($new_order > $current_order) {
        $g['current_status'] = $record['status'];
    }
    
    if ($record['updated_at'] > $g['updated_at']) {
        $g['updated_at'] = $record['updated_at'];
    }
}

$flights = array_values($grouped_flights);

// Sort flights based on view mode
if ($view_mode === 'future_range') {
    // Future view: sort by flight_date ascending (soonest first)
    usort($flights, function($a, $b) {
        $a_date = $a['flight_date'] ?? '9999-12-31';
        $b_date = $b['flight_date'] ?? '9999-12-31';
        if ($a_date !== $b_date) {
            return strcmp($a_date, $b_date); // Ascending by date
        }
        // Same date: sort by ETA
        $a_eta = $a['eta'] ?? '23:59:59';
        $b_eta = $b['eta'] ?? '23:59:59';
        return strcmp($a_eta, $b_eta);
    });
} else {
    // Today/Past views: sort by status priority, then by updated_at
    usort($flights, function($a, $b) {
        $status_order = ['LOADING' => 1, 'ON_GROUND' => 2, 'INBOUND' => 3, 'EXPECTED' => 4, 'DEPARTED' => 5];
        $a_order = $status_order[$a['current_status']] ?? 6;
        $b_order = $status_order[$b['current_status']] ?? 6;
        if ($a_order !== $b_order) {
            return $a_order - $b_order;
        }
        return strcmp($b['updated_at'], $a['updated_at']);
    });
}

$data_hash = hfw_generate_hash($flights);
$last_updated = date('g:i:s A');

// Helper function for timer class (green < 45 min, yellow >= 45 min)
function get_timer_class($minutes) {
    if ($minutes >= GROUND_YELLOW_THRESHOLD) return 'warning';
    return 'normal';
}

// Helper function for progress percentage
function get_progress_pct($minutes) {
    return min(100, ($minutes / GROUND_BAR_MAX) * 100);
}

// Helper function to format ground time
function format_ground_time($minutes) {
    $hrs = floor($minutes / 60);
    $mins = $minutes % 60;
    if ($hrs > 0) {
        return sprintf('%dh %dm', $hrs, $mins);
    }
    return sprintf('%d min', $mins);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <meta name="robots" content="noindex, nofollow">
    <title>Hanscom Flight Watch</title>
    <script defer data-domain="lexingtonalarm.org" src="https://plausible.io/js/script.file-downloads.outbound-links.js"></script>
    <style>
        * { box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            color: #1a1a2e;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container { max-width: 1400px; margin: 0 auto; }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 25px 20px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 12px;
            color: #fff;
        }
        .header h1 { margin: 0; font-size: 1.8rem; }
        .header .subtitle { color: #a0a0b0; margin-top: 5px; font-size: 0.95rem; }
        
        /* Navigation */
        .nav-bar {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
            padding: 12px 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .nav-bar a {
            color: #666;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            border: 1px solid #e0e0e0;
            transition: all 0.2s;
        }
        .nav-bar a:hover { background: #f5f5f5; border-color: #ccc; }
        .nav-bar a.active { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }
        
        /* Meta Bar */
        .meta-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
            padding: 15px 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-size: 0.85rem;
            color: #666;
        }
        .meta-bar .date-display { color: #1a1a2e; font-size: 1.1rem; font-weight: 600; }
        .meta-bar a { color: #3b82f6; text-decoration: none; }
        
        /* No Flights */
        .no-flights {
            text-align: center;
            padding: 60px 20px;
            color: #888;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .no-flights .icon { font-size: 3rem; margin-bottom: 15px; }
        
        /* Flight Grid */
        .flight-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
            align-items: flex-start;
        }
        
        /* Flight Card */
        .flight-card {
            width: 380px;
            background: #fff;
            border-radius: 20px;
            border: 2px solid #1a1a2e;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        /* Card Header - ALL text white */
        .card-header {
            padding: 18px 20px;
            background: #1a1a2e;
            color: #fff;
        }
        .card-header, .card-header *:not(.current-status) {
            color: #ffffff;
        }
        .card-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .flight-id { font-size: 0.7rem; color: #ffffff; margin-bottom: 4px; }
        .tail-number { font-size: 1.5rem; font-weight: bold; margin: 0; color: #ffffff; }
        .carrier { color: #ffffff; font-size: 0.9rem; margin-top: 3px; }
        .current-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .current-status.EXPECTED { background: #dbeafe; color: #1e40af; }
        .current-status.INBOUND { background: #d1fae5; color: #065f46; }
        .current-status.ON_GROUND { background: #fef3c7; color: #92400e; }
        .current-status.LOADING { background: #fee2e2; color: #991b1b; }
        .current-status.DEPARTED { background: #e5e7eb; color: #374151; }
        
        .flight-date {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 8px;
        }
        
        /* Status Stack */
        .status-stack {
            flex: 1;
            padding: 15px;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: 200px;
        }
        
        /* Status Box */
        .status-box {
            padding: 14px 16px;
            border-radius: 10px;
            border-left: 5px solid;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .status-box.DEPARTED { border-color: #6b7280; background: #f9fafb; }
        .status-box.LOADING { border-color: #ef4444; background: #fef2f2; }
        .status-box.ON_GROUND { border-color: #f59e0b; background: #fffbeb; }
        .status-box.INBOUND { border-color: #10b981; background: #ecfdf5; }
        .status-box.EXPECTED { border-color: #3b82f6; background: #eff6ff; }
        
        .status-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .status-box-title {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-box.DEPARTED .status-box-title { color: #4b5563; }
        .status-box.LOADING .status-box-title { color: #dc2626; }
        .status-box.ON_GROUND .status-box-title { color: #d97706; }
        .status-box.INBOUND .status-box-title { color: #059669; }
        .status-box.EXPECTED .status-box-title { color: #2563eb; }
        
        .status-box-time { font-size: 0.8rem; color: #666; font-weight: 500; }
        
        .status-details { font-size: 0.85rem; color: #333; }
        .detail-row { display: flex; gap: 8px; margin-top: 4px; }
        .detail-label { color: #555; min-width: 60px; }
        .detail-value { color: #111; font-weight: 500; }
        
        /* Ground Timer (Live) */
        .ground-timer {
            background: #fff;
            border: 2px solid;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            margin-top: 10px;
        }
        .ground-timer.normal { border-color: #10b981; }
        .ground-timer.warning { border-color: #f59e0b; }
        
        .timer-label {
            font-size: 0.65rem;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .timer-value {
            font-size: 1.8rem;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }
        .timer-value.normal { color: #059669; }
        .timer-value.warning { color: #d97706; }
        
        .progress-container {
            margin-top: 8px;
        }
        .progress-bar-wrapper {
            position: relative;
            height: 24px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: visible;
        }
        /* Marker lines at 45m, 1h, 1h15m, 1h30m (positions: 37.5%, 50%, 62.5%, 75%) */
        .progress-marker {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #666;
            z-index: 2;
        }
        .progress-marker.m45 { left: 37.5%; }
        .progress-marker.m60 { left: 50%; }
        .progress-marker.m75 { left: 62.5%; }
        .progress-marker.m90 { left: 75%; }
        .progress-marker-label {
            position: absolute;
            top: -16px;
            font-size: 0.55rem;
            color: #666;
            transform: translateX(-50%);
            white-space: nowrap;
        }
        .progress-marker.m45 .progress-marker-label { left: 0; }
        .progress-marker.m60 .progress-marker-label { left: 0; }
        .progress-marker.m75 .progress-marker-label { left: 0; }
        .progress-marker.m90 .progress-marker-label { left: 0; }
        .progress-fill {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            border-radius: 6px;
            transition: width 0.5s;
            z-index: 1;
        }
        .progress-fill.normal { background: #10b981; }
        .progress-fill.warning { background: #f59e0b; }
        .progress-endpoints {
            display: flex;
            justify-content: space-between;
            font-size: 0.6rem;
            color: #888;
            margin-top: 4px;
        }
        
        /* Total Ground Time (Departed) */
        .total-ground-time {
            background: #f3f4f6;
            border-radius: 6px;
            padding: 10px 12px;
            margin-top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-ground-time .label {
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
        }
        .total-ground-time .value {
            font-size: 1.1rem;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }
        .total-ground-time .value.normal { color: #059669; }
        .total-ground-time .value.warning { color: #d97706; }
        
        /* Card Footer - ALL text white */
        .card-footer {
            padding: 14px 18px;
            background: #1a1a2e;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-footer, .card-footer * {
            color: #ffffff;
        }
        .route-display { font-size: 0.85rem; color: #ffffff; }
        .route-display strong { color: #fff; }
        .download-btn {
            font-size: 0.75rem;
            color: #fff;
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid #fff;
            border-radius: 6px;
        }
        .download-btn:hover { background: #fff; color: #1a1a2e; }
        
        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 0.8rem;
            color: #888;
        }
        .footer .hash {
            font-family: 'Courier New', monospace;
            background: #e5e7eb;
            padding: 2px 8px;
            border-radius: 4px;
        }
        
        /* Mobile */
        @media (max-width: 768px) {
            .flight-card { width: 100%; max-width: 400px; }
            .nav-bar a { padding: 6px 10px; font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✈️ Hanscom Flight Watch</h1>
            <div class="subtitle">Real-Time Deportation Flight Monitoring — KBED</div>
        </div>
        
        <div class="nav-bar">
            <a href="?" class="<?php echo $view_mode === 'today' ? 'active' : ''; ?>">Today</a>
            <a href="?date=<?php echo $yesterday; ?>" class="<?php echo ($view_mode === 'date' && $view_date === $yesterday) ? 'active' : ''; ?>">Prior Day</a>
            <a href="?range=7" class="<?php echo ($view_mode === 'past_range' && $view_range == 7) ? 'active' : ''; ?>">Prior 7 Days</a>
            <a href="?future=7" class="<?php echo ($view_mode === 'future_range' && $view_range == 7) ? 'active' : ''; ?>">Next 7 Days</a>
        </div>
        
        <div class="meta-bar">
            <div class="date-display"><?php echo $display_title; ?></div>
            <div>Last updated: <?php echo $last_updated; ?> <span style="color:#999">(auto-refresh 30s)</span></div>
            <div><a href="api.php">JSON Data</a></div>
        </div>
        
        <?php if (empty($flights)): ?>
            <div class="no-flights">
                <div class="icon">📡</div>
                <div style="font-size: 1.1rem; color: #555;">No flights tracked <?php echo ($view_mode === 'today') ? 'today' : 'for this period'; ?></div>
                <?php if ($view_mode === 'today'): ?>
                    <div style="margin-top: 10px;">Monitoring active — data will appear when flights are reported</div>
                <?php elseif ($view_mode === 'future_range'): ?>
                    <div style="margin-top: 10px;">No scheduled flights in this period</div>
                <?php else: ?>
                    <div style="margin-top: 10px;">No flight observations recorded</div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            
            <div class="flight-grid">
                <?php foreach ($flights as $flight): 
                    // Calculate ground time - count up from landed_at
                    $ground_elapsed = null;
                    $is_departed = !empty($flight['departed_at']);
                    
                    if (!empty($flight['landed_at'])) {
                        $landed = strtotime($flight['landed_at']);
                        $now = time();
                        $end = $is_departed ? strtotime($flight['departed_at']) : $now;
                        $ground_elapsed = round(($end - $landed) / 60);
                        
                        // Clamp to zero minimum (never negative)
                        if ($ground_elapsed < 0) {
                            $ground_elapsed = 0;
                        }
                    }
                    
                    $timer_class = ($ground_elapsed !== null) ? get_timer_class($ground_elapsed) : 'normal';
                    $ground_pct = ($ground_elapsed !== null) ? get_progress_pct($ground_elapsed) : 0;
                    
                    $display_id = !empty($flight['tail_number']) ? $flight['tail_number'] : $flight['carrier'];
                    $primary_flight_id = $flight['flight_ids'][0] ?? '';
                ?>
                
                <div class="flight-card">
                    
                    <!-- HEADER -->
                    <div class="card-header">
                        <div class="card-header-row">
                            <div>
                                <div class="flight-id"><?php echo htmlspecialchars($primary_flight_id); ?></div>
                                <div class="tail-number"><?php echo htmlspecialchars($display_id ?: '—'); ?></div>
                                <div class="carrier"><?php echo htmlspecialchars($flight['carrier'] ?: 'Unknown carrier'); ?></div>
                            </div>
                            <div style="text-align: right;">
                                <div class="current-status <?php echo $flight['current_status']; ?>">
                                    <?php echo str_replace('_', ' ', $flight['current_status']); ?>
                                </div>
                                <?php 
                                // Derive flight_date from alert_at or created_at if not set
                                $display_date = $flight['flight_date'];
                                if (empty($display_date) && !empty($flight['alert_at'])) {
                                    $display_date = date('Y-m-d', strtotime($flight['alert_at']));
                                } elseif (empty($display_date) && !empty($flight['created_at'])) {
                                    $display_date = date('Y-m-d', strtotime($flight['created_at']));
                                }
                                if (!empty($display_date)): 
                                ?>
                                <div class="flight-date"><?php echo date('D, M j', strtotime($display_date)); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STATUS STACK -->
                    <div class="status-stack">
                        
                        <?php if ($is_departed): ?>
                        <div class="status-box DEPARTED">
                            <div class="status-box-header">
                                <span class="status-box-title">🛫 Departed</span>
                                <span class="status-box-time"><?php echo hfw_format_time($flight['departed_at']); ?></span>
                            </div>
                            <div class="status-details">
                                <?php if (!empty($flight['destination'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">To:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($flight['destination']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($flight['loading_at'])): ?>
                        <div class="status-box LOADING">
                            <div class="status-box-header">
                                <span class="status-box-title">⚠️ Loading</span>
                                <span class="status-box-time"><?php echo hfw_format_time($flight['loading_at']); ?></span>
                            </div>
                            <?php if ($flight['current_status'] === 'LOADING' && $ground_elapsed !== null): ?>
                            <!-- Live Timer for LOADING -->
                            <div class="ground-timer <?php echo $timer_class; ?>">
                                <div class="timer-label">Time on Ground</div>
                                <div class="timer-value <?php echo $timer_class; ?>" 
                                     data-landed="<?php echo strtotime($flight['landed_at']); ?>"
                                     data-yellow="<?php echo GROUND_YELLOW_THRESHOLD; ?>">
                                    <?php 
                                    $hrs = floor($ground_elapsed / 60);
                                    $mins = $ground_elapsed % 60;
                                    echo sprintf('%d:%02d', $hrs, $mins);
                                    ?>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar-wrapper">
                                        <div class="progress-marker m45"><span class="progress-marker-label">45m</span></div>
                                        <div class="progress-marker m60"><span class="progress-marker-label">1h</span></div>
                                        <div class="progress-marker m75"><span class="progress-marker-label">1h15</span></div>
                                        <div class="progress-marker m90"><span class="progress-marker-label">1h30</span></div>
                                        <div class="progress-fill <?php echo $timer_class; ?>" 
                                             style="width: <?php echo $ground_pct; ?>%;"
                                             data-max="<?php echo GROUND_BAR_MAX; ?>"></div>
                                    </div>
                                    <div class="progress-endpoints">
                                        <span>0</span>
                                        <span>2h</span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($flight['landed_at'])): ?>
                        <div class="status-box ON_GROUND">
                            <div class="status-box-header">
                                <span class="status-box-title">🛬 On Ground</span>
                                <span class="status-box-time"><?php echo hfw_format_time($flight['landed_at']); ?></span>
                            </div>
                            
                            <?php if ($is_departed && $ground_elapsed !== null): ?>
                            <!-- Fixed Total for DEPARTED -->
                            <div class="total-ground-time">
                                <span class="label">Total Time on Ground</span>
                                <span class="value <?php echo $timer_class; ?>"><?php echo format_ground_time($ground_elapsed); ?></span>
                            </div>
                            <?php elseif ($flight['current_status'] === 'ON_GROUND' && $ground_elapsed !== null): ?>
                            <!-- Live Timer for ON_GROUND -->
                            <div class="ground-timer <?php echo $timer_class; ?>">
                                <div class="timer-label">Time on Ground</div>
                                <div class="timer-value <?php echo $timer_class; ?>" 
                                     data-landed="<?php echo strtotime($flight['landed_at']); ?>"
                                     data-yellow="<?php echo GROUND_YELLOW_THRESHOLD; ?>">
                                    <?php 
                                    $hrs = floor($ground_elapsed / 60);
                                    $mins = $ground_elapsed % 60;
                                    echo sprintf('%d:%02d', $hrs, $mins);
                                    ?>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar-wrapper">
                                        <div class="progress-marker m45"><span class="progress-marker-label">45m</span></div>
                                        <div class="progress-marker m60"><span class="progress-marker-label">1h</span></div>
                                        <div class="progress-marker m75"><span class="progress-marker-label">1h15</span></div>
                                        <div class="progress-marker m90"><span class="progress-marker-label">1h30</span></div>
                                        <div class="progress-fill <?php echo $timer_class; ?>" 
                                             style="width: <?php echo $ground_pct; ?>%;"
                                             data-max="<?php echo GROUND_BAR_MAX; ?>"></div>
                                    </div>
                                    <div class="progress-endpoints">
                                        <span>0</span>
                                        <span>2h</span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($flight['origin_departed_at']) || !empty($flight['confirmed_at'])): ?>
                        <div class="status-box INBOUND">
                            <div class="status-box-header">
                                <span class="status-box-title">✈️ Inbound</span>
                                <span class="status-box-time"><?php echo hfw_format_time($flight['origin_departed_at'] ?: $flight['confirmed_at']); ?></span>
                            </div>
                            <div class="status-details">
                                <?php if (!empty($flight['origin_departed_at'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">Left:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($flight['origin'] ?: 'Origin'); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($flight['eta'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">ETA:</span>
                                    <span class="detail-value"><?php echo hfw_format_time($flight['eta']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($flight['alert_at'])): ?>
                        <div class="status-box EXPECTED">
                            <div class="status-box-header">
                                <span class="status-box-title">📋 Scheduled</span>
                                <span class="status-box-time"><?php echo hfw_format_time($flight['alert_at']); ?></span>
                            </div>
                            <div class="status-details">
                                <?php if (!empty($flight['alert_reason'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">Source:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($flight['alert_reason']); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($flight['origin'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">Origin:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($flight['origin']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                    
                    <!-- FOOTER -->
                    <div class="card-footer">
                        <div class="route-display">
                            <strong><?php echo htmlspecialchars($flight['origin'] ?: '?'); ?></strong>
                            → KBED
                            <?php if (!empty($flight['destination'])): ?>
                            → <strong><?php echo htmlspecialchars($flight['destination']); ?></strong>
                            <?php endif; ?>
                        </div>
                        <a href="record.php?id=<?php echo urlencode($primary_flight_id); ?>" class="download-btn" target="_blank">📄 Record</a>
                    </div>
                    
                </div>
                
                <?php endforeach; ?>
            </div>
            
        <?php endif; ?>
        
        <div class="footer">
            <div>Data hash: <span class="hash"><?php echo $data_hash; ?></span></div>
            <div style="margin-top: 8px;">Hanscom Flight Watch • Real-time deportation flight monitoring</div>
            <div style="margin-top: 12px; font-size: 0.75rem; color: #999;">All data sourced from public records including ADS-B Exchange, FlightAware, FAA registrations, and observations from public areas.</div>
        </div>
    </div>
    
    <script>
        // Thresholds from PHP
        var YELLOW_THRESHOLD = <?php echo GROUND_YELLOW_THRESHOLD; ?>;
        var BAR_MAX = <?php echo GROUND_BAR_MAX; ?>;
        
        function getTimerClass(minutes) {
            if (minutes >= YELLOW_THRESHOLD) return 'warning';
            return 'normal';
        }
        
        function updateTimers() {
            document.querySelectorAll('.timer-value[data-landed]').forEach(function(el) {
                var landed = parseInt(el.dataset.landed);
                var now = Math.floor(Date.now() / 1000);
                var elapsed = Math.floor((now - landed) / 60);
                
                // Never show negative - only count UP from zero
                if (elapsed < 0) {
                    elapsed = 0;
                }
                
                var hrs = Math.floor(elapsed / 60);
                var mins = elapsed % 60;
                el.textContent = hrs + ':' + (mins < 10 ? '0' : '') + mins;
                
                var timerClass = getTimerClass(elapsed);
                
                // Update timer color
                el.classList.remove('normal', 'warning');
                el.classList.add(timerClass);
                
                // Update timer border
                var timerBox = el.closest('.ground-timer');
                if (timerBox) {
                    timerBox.classList.remove('normal', 'warning');
                    timerBox.classList.add(timerClass);
                }
                
                // Update progress bar
                var progressBar = el.closest('.ground-timer').querySelector('.progress-fill');
                if (progressBar) {
                    var pct = Math.min(100, (elapsed / BAR_MAX) * 100);
                    progressBar.style.width = pct + '%';
                    progressBar.classList.remove('normal', 'warning');
                    progressBar.classList.add(timerClass);
                }
            });
        }
        
        // Update every second
        setInterval(updateTimers, 1000);
    </script>
</body>
</html>
