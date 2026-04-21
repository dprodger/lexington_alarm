# Local Development Change Log

## Purpose
Track all changes made in local development that need to be replicated during final migration.

## Configuration Changes

### Database Updates
- [ ] URLs changed from `bpx.ela.mybluehost.me/website_97a098b6` to `lexingtonalarm.org`
- [ ] User accounts reviewed and cleaned
- [ ] Spam comments removed
- [ ] Test orders deleted

### Plugin Configuration
- [ ] WPCode snippets tested and verified
- [ ] WooCommerce settings updated
- [ ] Payment gateway configured for production
- [ ] Email SMTP settings configured

### Theme Customizations
- [ ] Font paths updated (removed `/website_97a098b6/`)
- [ ] Custom CSS reviewed and optimized
- [ ] Mobile responsive issues fixed
- [ ] Banner scaling verified

### Code Snippet Updates
- [ ] Snippet 1: _________________ (tested/modified)
- [ ] Snippet 2: _________________ (tested/modified)
- [ ] Snippet 3: _________________ (tested/modified)

### Content Updates
- [ ] Pages reviewed and updated
- [ ] Broken links fixed
- [ ] Images optimized
- [ ] Forms tested

## Migration Checklist

### Pre-Migration (from local testing)
- [ ] All snippets work
- [ ] No PHP errors in debug log
- [ ] Forms submit correctly
- [ ] Payment system tested
- [ ] Email notifications work

### Migration Steps (to production)
1. [ ] Use ARCHIVE files (wordpress_site/), not local
2. [ ] Apply documented changes from this log
3. [ ] Run tested SQL updates
4. [ ] Import verified code snippets
5. [ ] Apply theme customizations

### Post-Migration Verification
- [ ] All pages load
- [ ] Sign ordering works
- [ ] Calendar displays
- [ ] Mobile responsive
- [ ] SSL certificate active

## Notes
- Keep wordpress_site/ untouched as fallback
- Document every change made in local
- Test thoroughly before migration
- Have rollback plan ready

---

Last Updated: [date]
Changes Made By: [name]