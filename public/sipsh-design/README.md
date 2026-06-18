# SIPSH Design System

A modern and premium e-commerce design system tailored for **SIPSH**, focusing on:
- **Glassmorphism** with polished effects
- **Rounded corners** for approachable visuals
- **Micro-animations** for interaction feedback
- Clean and **spacious layouts**

## Foundations

### Color Palette

- **Primary:** Gradient overlay (#FF6F61 → #D8345F)
- **Secondary:** Soft blue (#6A9CF1)
- **Accent:** Vibrant yellow (#FFDD57)
- **Neutral:** Clean tones (#FAFAFA and #EDEDED)
- **Dark:** Deep charcoal (#333333) & Deep navy (#1A1A2E)

### Typography

- **Font Family:** Nunito Sans (Google Fonts)
- **Weights:** 300, 400, 600, 700, 800
- **Sizes (clamp):** H1: 28–44px, H2: 22–36px, H3: 18–28px, Body: 16px

### Icon Library

- **Material Icons Round** — shopping cart, user, navigation, actions.

---

## 7 Halaman Inti — Responsive Layouts

All pages are built with **mobile-first responsive design** using 3 breakpoints:

| Breakpoint | Range | Behavior |
|-----------|-------|----------|
| **Mobile** | ≤ 600px | Single column, stacked nav, card-style tables |
| **Tablet** | 601–1024px | 2–3 column grids, collapsible sidebars |
| **Desktop** | ≥ 1025px | Full multi-column, sticky sidebars/filters |

### 1. Landing Page (`landing-page/index.html`)
- Hero section with gradient background, CTA buttons, decorative blobs
- Featured categories (4-card auto-fit grid)
- Product highlights with sale badges
- Benefits strip (free shipping, secure payment, etc.)
- Testimonials (3-column auto-fit)
- Newsletter CTA
- Full footer

### 2. Shop (`shop/index.html`)
- Sidebar filters: Category, Price range, Size, Rating
- Toolbar: sort dropdown + result count
- Auto-fit product grid (2 columns on mobile, 3-4 on desktop)
- Product cards: image, title, rating stars, price, sale badge
- Pagination controls
- Mobile: filter toggle button, stacked layout

### 3. Product Detail (`product-detail/index.html`)
- Breadcrumb navigation
- 2-column layout: gallery (main + 4 thumbnails) + product info
- Info: category tag, title, rating, price + discount, description
- Size selector (S–XXL) & color selector (4 swatches)
- Quantity control + Add to Cart + Save buttons
- Shipping info glass card
- Specifications table
- Reviews section with ratings aggregate + 3 review cards
- Related products grid

### 4. Cart (`cart/index.html`)
- Coupon code input row
- Cart items: image, title+variant, quantity control, price, remove button
- Sticky summary sidebar: subtotal, shipping, discount, tax, total
- Checkout CTA + "Continue Shopping" link
- Mobile: stacked layout, summary moves below items

### 5. Seller Dashboard (`seller-dashboard/index.html`)
- Sidebar navigation (Dashboard, Products, Orders, Finance, Reviews, Promotions, Settings)
- Stats grid (Total Sales, Orders, Products Sold, Visitors) with trend arrows
- 2-column section: Sales chart placeholder + Top Products (ranked list)
- Recent Orders table with status tags (Completed, Shipped, Processing, Cancelled)
- Mobile: hamburger sidebar, responsive table cards

### 6. Admin Dashboard (`admin-dashboard/index.html`)
- Sidebar navigation (Users, Sellers, Products, Orders, Transactions, Promotions, Reviews)
- Stats grid (Revenue, Orders, Registered Users, Active Sellers)
- 2-column: Revenue chart + Activity feed (timeline with colored dots)
- Quick Actions grid (Manage Users, Verify Sellers, Create Promotions, etc.)
- Users table (Name, Email, Role, Status, Joined date)
- Mobile: hamburger sidebar, responsive views

### 7. Auth Pages (`auth-pages/index.html`)
- Split layout: form side + gradient hero side
- Tab switcher: Login / Register with smooth toggle
- Login: email + password with show/hide toggle, forgot password link
- Register: name, email, phone, password, confirm password, terms checkbox
- Forgot Password panel (hidden tab)
- Social login buttons (Google, Apple, Facebook)
- Responsive: hero side hidden on mobile, full-width form

---

## Responsive CSS Architecture

Defined in `styles.css` (~1449 lines):

- **Variables:** `--breakpoint-mobile: 600px`, `--breakpoint-tablet: 1024px`
- **12-column Flex Grid:** `.col-1` through `.col-12`
- **Auto-fit Grid:** `grid-template-columns: repeat(auto-fill, minmax(240px, 1fr))`
- **Sidebar Layout:** `grid-template-columns: 260px 1fr` → collapses on mobile
- **Tablet (≤1024px):** Narrower sidebars, hidden auth hero, stacked hero-split
- **Mobile (≤600px):** Full-width nav stack, card-style tables (`data-label`), 2-col stats, stacked cart/detail/shop
- **Animations:** fadeIn, slideInLeft, slideInRight, scaleIn, stagger children
- **Utilities:** `.hide-mobile`, `.hide-tablet`, `.hide-desktop`, flex/gap helpers

### Component Library

| Component | CSS Class | Variants |
|-----------|-----------|----------|
| Buttons | `.btn` | `.btn-primary`, `.btn-secondary`, `.btn-accent`, `.btn-outline`, `.btn-ghost`, `.btn-sm`, `.btn-lg`, `.btn-block`, `.btn-icon` |
| Cards | `.card`, `.card-product` | `.card-header`, `.card-body`, `.card-footer` |
| Glass | `.glass`, `.glass-dark` | Backdrop blur + border |
| Tables | `.table-container` | Responsive on mobile (`data-label` pattern) |
| Forms | `.form-group`, `.form-input` | Checkbox, radio, select, textarea |
| Badges | `.tag` | `.tag-success`, `.tag-warning`, `.tag-error`, `.tag-info` |
| Stats | `.stat-card` | `.stat-card-primary`, `.stat-card-secondary` |
| Navigation | `.navbar` | `.navbar-nav`, `.navbar-toggle`, `.cart-badge` |
| Sidebar | `.sidebar`, `.sidebar-nav` | Sticky, dark theme |

---

## File Structure

```
SIPSH-design-system/
├── README.md
├── styles.css                       # Global design system (~1449 lines)
├── landing-page/index.html          # Responsive landing page
├── shop/index.html                  # Product listing with filters
├── product-detail/index.html        # Product detail + reviews
├── cart/index.html                  # Shopping cart + summary
├── seller-dashboard/index.html      # Seller analytics + orders
├── admin-dashboard/index.html       # Admin overview + users
└── auth-pages/index.html            # Login / Register / Forgot Password
```

---

## Getting Started

Open any `index.html` directly in a browser — no build step required.
All pages link to `../styles.css` for the shared design system.

For development:
1. Edit `styles.css` to update global tokens (colors, spacing, breakpoints)
2. Each page's `<style>` block contains page-specific overrides
3. Test all 3 breakpoints using browser DevTools responsive mode

---

## Future Work

- Checkout flow (shipping, payment, confirmation)
- User profile / account settings
- Order tracking page
- Product search results page
- Dark mode support via CSS custom properties
