# Finding Sales Figures by Product in WooCommerce

**Last Updated:** October 2025  
**Site:** https://bpx.ela.mybluehost.me/website_97a098b6/

---

## Quick Answer: Multiple Ways to View Sales Data

WooCommerce provides several built-in ways to view product sales data. Here are all the methods:

---

## Method 1: WooCommerce Analytics (RECOMMENDED)

**Best for:** Detailed reports, date ranges, comparisons, and exports

### Step-by-Step:

1. **Log into WordPress Admin**
   ```
   https://bpx.ela.mybluehost.me/website_97a098b6/wp-admin
   ```

2. **Navigate to Analytics**
   ```
   WooCommerce → Analytics → Products
   ```

3. **View Product Sales Report**
   - Shows all products with sales data
   - Columns include:
     - Product name
     - Items sold
     - Net sales
     - Orders
     - Date range

### Available Reports:

**Products Report:**
- Path: `WooCommerce → Analytics → Products`
- Shows: Units sold, revenue, orders per product
- Can filter by date range
- Can compare date ranges
- Exportable to CSV

**Orders Report:**
- Path: `WooCommerce → Analytics → Orders`
- Shows: Total orders, average order value
- Can see what products are in each order

**Revenue Report:**
- Path: `WooCommerce → Analytics → Revenue`
- Shows: Total sales, net sales
- Breakdown by product category

**Categories Report:**
- Path: `WooCommerce → Analytics → Categories`
- Shows: Sales by category (Shipping, Local Pickup, Donations)
- Useful for seeing fulfillment type breakdown

### Features:

✅ **Date Range Selector**
- Today, Yesterday, Week to date, Month to date
- Last 7 days, Last 30 days, Last quarter, Last year
- Custom date range

✅ **Advanced Filters**
- Filter by product category
- Filter by product
- Filter by customer type

✅ **Compare Periods**
- Compare current period to previous period
- See growth/decline percentages

✅ **Export to CSV**
- Download button in top right
- Opens in Excel/Google Sheets
- All data included

---

## Method 2: Individual Product Pages

**Best for:** Quick check on a specific product

### Step-by-Step:

1. **Go to Products**
   ```
   WooCommerce → Products
   ```

2. **Click on Product Name**
   - Opens product edit page

3. **Scroll to "Product Data" Box**
   - Under the title, you'll see product details

4. **Look for "Total Sales"**
   - Shows lifetime sales count for that product
   - Format: "Total sales: XX"
   - Located near the product type dropdown

### What You'll See:
```
Total sales: 15
```
This means the product has sold 15 units total since creation.

---

## Method 3: Products List Table

**Best for:** Quick scan of all products at once

### Step-by-Step:

1. **Go to Products List**
   ```
   WooCommerce → Products
   ```

2. **Look at Table Columns**
   - Product name
   - SKU
   - Stock status
   - Price
   - Categories
   - Date

3. **Add "Total Sales" Column** (if not visible)
   - Click "Screen Options" (top right)
   - Check box for "Total Sales"
   - Click Apply

### Result:
You'll see a sortable column showing total sales per product.

---

## Method 4: WooCommerce Reports (Classic)

**Best for:** Legacy interface, still available

### Step-by-Step:

1. **Navigate to Reports**
   ```
   WooCommerce → Reports
   ```

2. **Select "Orders" Tab**
   - Shows sales by date

3. **Select "Products" Sub-tab**
   - Shows top sellers
   - Sales in selected period
   - Total orders

### Available Classic Reports:

**Products by Date:**
- Sales per product in date range
- Shows units sold and revenue

**Top Sellers:**
- Products sorted by units sold
- Good for identifying best sellers

**Top Earners:**
- Products sorted by revenue
- Good for identifying highest revenue items

---

## Method 5: Order Export for Custom Analysis

**Best for:** Detailed Excel analysis, custom reports

### Step-by-Step:

1. **Go to Orders**
   ```
   WooCommerce → Orders
   ```

2. **Filter if Needed**
   - Filter by date range
   - Filter by status (completed, processing, etc.)

3. **Use Bulk Actions**
   - Check boxes for orders to export
   - Or: Select all orders
   - Bulk Actions → Export (if plugin installed)

4. **Alternative: Use WooCommerce Export**
   ```
   WooCommerce → Settings → Advanced → Export
   ```

### Manual Method:
If no export plugin, you can:
1. Copy order data from each order
2. Create custom export using WPCode snippet
3. Use plugin like "WooCommerce Customer / Order / Coupon Export"

---

## Specific Reports You Might Want

### Report 1: Total Sales by Product (All Time)

**Location:** `WooCommerce → Analytics → Products`
**Settings:** Date range = "All time" or "Year to date"
**Shows:**
- 18" x 24" Yard Sign: XX units sold
- 12" x 18" Window Sign: XX units sold
- 5 Yard Sign Pack: XX units sold
- Etc.

### Report 2: Sales by Category (Shipping vs Pickup)

**Location:** `WooCommerce → Analytics → Categories`
**Settings:** Select date range
**Shows:**
- Shipping category: XX units, $XXX revenue
- Local Pickup category: XX units, $XXX revenue
- Donations category: XX donations, $XXX total

### Report 3: Monthly Sales Trend

**Location:** `WooCommerce → Analytics → Products`
**Settings:** 
- Date range = "This month"
- Compare to = "Previous month"
**Shows:**
- Monthly comparison
- Growth/decline percentages

### Report 4: Best Sellers

**Location:** `WooCommerce → Reports → Products → Top Sellers`
**Shows:**
- Products ranked by units sold
- Good for inventory planning

---

## Custom Sales Report (Advanced)

If you need a specific report format, you can create a custom report using a plugin or snippet.

### Using WPCode Snippet (Example):

```php
// Quick sales summary - access via ?sales_summary=true
add_action('init', 'lexington_sales_summary');
function lexington_sales_summary() {
    if (isset($_GET['sales_summary']) && current_user_can('manage_options')) {
        echo '<h1>Lexington Alarm Sales Summary</h1>';
        
        $products = wc_get_products(array('limit' => -1));
        
        echo '<table border="1" cellpadding="10">';
        echo '<tr><th>Product</th><th>SKU</th><th>Total Sales</th><th>Stock</th></tr>';
        
        foreach ($products as $product) {
            echo '<tr>';
            echo '<td>' . $product->get_name() . '</td>';
            echo '<td>' . $product->get_sku() . '</td>';
            echo '<td>' . $product->get_total_sales() . '</td>';
            echo '<td>' . $product->get_stock_quantity() . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        exit;
    }
}
```

Access via: `yoursite.com/?sales_summary=true`

---

## Recommended Plugins for Enhanced Reporting

### Free Options:

**1. WooCommerce Customer / Order / Coupon Export**
- Export orders to CSV
- Include product details
- Filter by date/status

**2. Advanced Order Export For WooCommerce**
- Export orders and products
- Custom field mapping
- Scheduled exports

### Paid Options:

**1. Metorik** ($50/month)
- Advanced WooCommerce analytics
- Real-time reporting
- Beautiful dashboards

**2. Putler** ($20/month)
- Product performance reports
- Customer insights
- RFM analysis

---

## Quick Reference: Where to Find What

| What You Want | Where to Go | Path |
|---------------|-------------|------|
| Sales by product | Analytics | WooCommerce → Analytics → Products |
| Sales by category | Analytics | WooCommerce → Analytics → Categories |
| Total revenue | Analytics | WooCommerce → Analytics → Revenue |
| Order details | Orders | WooCommerce → Orders |
| Top sellers | Classic Reports | WooCommerce → Reports → Products → Top Sellers |
| Single product sales | Product edit | Products → [Edit Product] → Total Sales |
| Custom date range | Analytics | Use date picker in Analytics |
| Export to Excel | Analytics | Click "Download" button |

---

## Sample Reports You Can Generate

### Weekly Sales Report

**Setup:**
1. Go to: `WooCommerce → Analytics → Products`
2. Date range: "Last 7 days"
3. Click "Download" for CSV

**Result:**
```
Product Name          | Items Sold | Net Sales | Orders
5 Yard Sign Pack      | 12        | $540.00   | 8
18" x 24" Yard Sign   | 25        | $250.00   | 25
Window Sign 12x18     | 8         | $120.00   | 7
```

### Monthly Revenue by Category

**Setup:**
1. Go to: `WooCommerce → Analytics → Categories`
2. Date range: "This month"
3. View report

**Result:**
```
Category        | Items Sold | Net Sales | % of Total
Shipping        | 45        | $2,250    | 65%
Local Pickup    | 30        | $900      | 26%
Donations       | 15        | $325      | 9%
```

---

## Data You Can Track

### Product-Level Metrics:
- Units sold (all time or date range)
- Revenue generated
- Number of orders containing product
- Average order value for orders with product
- Refunds/returns

### Category-Level Metrics:
- Sales by fulfillment type (Shipping/Pickup/Donation)
- Revenue per category
- Items sold per category

### Time-Based Metrics:
- Daily sales
- Weekly trends
- Monthly comparisons
- Year-over-year growth

---

## Tips for Better Reporting

### 1. Set Up Regular Exports
Schedule weekly CSV exports to track trends over time

### 2. Use Date Comparisons
Compare "Last 30 days" vs "Previous period" to see growth

### 3. Filter by Status
Only include "Completed" orders for accurate revenue (exclude pending/cancelled)

### 4. Track by Category
Monitor Shipping vs Pickup vs Donations separately

### 5. SKU System
Ensure all products have SKUs for easier tracking and export analysis

---

## Common Questions

**Q: How do I see sales for just completed orders?**
A: In Analytics, orders are automatically filtered to completed/processing. In Orders list, use status filter.

**Q: Can I see which products were ordered together?**
A: Not directly in Analytics, but you can view individual orders to see product combinations.

**Q: How do I track donations separately?**
A: Use Categories report to see "Donations" category separately from physical products.

**Q: Can I see sales by coordinator/pickup location?**
A: Not by default, but can be added with custom order meta and reporting.

**Q: How do I export for Excel analysis?**
A: Use "Download" button in Analytics → Products, saves as CSV that opens in Excel.

---

## Next Steps: Enhanced Reporting

### When You're Ready:

**1. Dashboard Widget**
Add sales summary to WordPress dashboard for quick daily view

**2. Email Reports**
Automated daily/weekly sales summary emails

**3. Real-Time Notifications**
Get notified when orders come in (already set up with email)

**4. Inventory Alerts**
Auto-alert when products run low based on sales velocity

---

## Quick Access URLs

**Analytics Dashboard:**
```
/wp-admin/admin.php?page=wc-admin&path=/analytics/overview
```

**Products Report:**
```
/wp-admin/admin.php?page=wc-admin&path=/analytics/products
```

**Categories Report:**
```
/wp-admin/admin.php?page=wc-admin&path=/analytics/categories
```

**Orders Report:**
```
/wp-admin/admin.php?page=wc-admin&path=/analytics/orders
```

**Classic Reports:**
```
/wp-admin/admin.php?page=wc-reports
```

---

**Pro Tip:** Bookmark the Analytics → Products page for quick daily sales checks!
