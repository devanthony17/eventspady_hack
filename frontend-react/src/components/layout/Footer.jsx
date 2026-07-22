import { Link } from 'react-router-dom'

export default function Footer({ setting }) {
  const year = new Date().getFullYear()
  return (
    <footer className="site-footer">
      <div className="footer-inner">
        <div className="footer-brand">
          <span className="brand-icon">🎟</span>
          <span className="brand-name">{setting?.app_name || 'Eventspady'}</span>
          <p className="footer-tagline">Discover & book amazing events near you.</p>
        </div>

        <div className="footer-links">
          <div className="footer-col">
            <h4>Explore</h4>
            <Link to="/">Home</Link>
            <Link to="/events">Events</Link>
            <Link to="/categories">Categories</Link>
            <Link to="/blogs">Blogs</Link>
          </div>
          <div className="footer-col">
            <h4>Account</h4>
            <Link to="/login">Sign In</Link>
            <Link to="/register">Register</Link>
            <Link to="/profile">Profile</Link>
            <Link to="/my-tickets">My Tickets</Link>
          </div>
          <div className="footer-col">
            <h4>Company</h4>
            <Link to="/contact">Contact Us</Link>
            <a href="#!">Privacy Policy</a>
            <a href="#!">Terms of Service</a>
          </div>
        </div>
      </div>

      <div className="footer-bottom">
        <p>© {year} {setting?.app_name || 'Eventspady'}. All rights reserved.</p>
      </div>
    </footer>
  )
}
