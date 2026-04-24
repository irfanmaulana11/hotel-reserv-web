# hotel-reserv-web

## Key Features

### Google Authentication
- **Login via Google**: Authenticate using your Google account for secure access
- **Auto-registration**: New users are automatically created with email-based verification
- **Profile Sync**: Name, avatar, and email details are pulled from Google

### Stripe Payment Integration
- **Checkout Flow**: Create payment sessions via `POST /stripe/checkout`
- **Webhook Handling**: Automatically process payment events and confirmations
- **Tax Calculation**: 11% VAT applied to bookings
- **Reference System**: Unique HRW-XXXX references for all transactions

### Booking System
- **Search & Compare**: Filter hotels by city, dates, and room types
- **Multi-room Booking**: Book multiple rooms in a single reservation
- **Order History**: Track past bookings via `/orders` endpoint

## Technical Implementation
**Authentication**
- Laravel Socialite for Google OAuth
- Sessions managed via `auth()->id()`

**Payments**
- Stripe Checkout Sessions
- Webhook endpoint `/stripe/webhook` for real-time updates
- Reservation creation linked to payment success

**Technology Stack**
- **Backend Framework**: Laravel 13.0
- **Frontend Build**: Vite 8.x
- **Database**: MySQL (primary), SQLite (default fallback)

## API Endpoints
**Google Auth**
- `GET /auth/google` - Redirect to Google login
- `GET /auth/google/callback` - Handle authentication response

**Stripe**
- `POST /stripe/checkout` - Initiate payment session
- `GET /stripe/success` - Payment success page
- `GET /stripe/cancel` - Payment cancellation
- `POST /stripe/webhook` - Payment status updates