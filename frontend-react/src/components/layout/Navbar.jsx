import { useState, useEffect, useRef } from 'react'
import { Link, NavLink, useNavigate } from 'react-router-dom'
import { useAuth } from '../../context/AuthContext'
import api from '../../api/api'

export default function Navbar({ setting }) {
  const { isLoggedIn, user, logout } = useAuth()
  const [categories, setCategories] = useState([])
  const [catOpen, setCatOpen] = useState(false)
  const [profileOpen, setProfileOpen] = useState(false)
  const [mobileOpen, setMobileOpen] = useState(false)
  const [search, setSearch] = useState('')
  const navigate = useNavigate()
  const catRef = useRef()
  const profileRef = useRef()

  useEffect(() => {
    api.get('/user/category').then((r) => setCategories(r.data?.data || []))
  }, [])

  // Close dropdowns on outside click
  useEffect(() => {
    const handler = (e) => {
      if (catRef.current && !catRef.current.contains(e.target)) setCatOpen(false)
      if (profileRef.current && !profileRef.current.contains(e.target)) setProfileOpen(false)
    }
    document.addEventListener('mousedown', handler)
    return () => document.removeEventListener('mousedown', handler)
  }, [])

  const handleSearch = (e) => {
    e.preventDefault()
    if (search.trim()) navigate(`/events?q=${encodeURIComponent(search.trim())}`)
  }

  const handleLogout = () => {
    logout()
    navigate('/')
  }

  return (
    <header className="navbar-wrapper">
      {/* Top bar */}
      <nav className="top-nav">
        <div className="nav-container">
          <Link to="/" className="brand">
            <span className="brand-icon">🎟</span>
            <span className="brand-name">{setting?.app_name || 'Eventspady'}</span>
          </Link>

          <form className="nav-search-form" onSubmit={handleSearch}>
            <input
              type="text"
              placeholder="Search events, locations..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="nav-search-input"
            />
            <button type="submit" className="nav-search-btn" aria-label="Search">
              <svg width="16" height="16" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
              </svg>
            </button>
          </form>

          <div className="nav-actions">
            {isLoggedIn ? (
              <div className="profile-dropdown" ref={profileRef}>
                <button className="profile-btn" onClick={() => setProfileOpen(!profileOpen)}>
                  <img
                    src={user?.image ? `/images/upload/${user.image}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user?.name || 'U')}&background=6c63ff&color=fff`}
                    alt={user?.name}
                    className="profile-avatar"
                  />
                  <span className="profile-name">{user?.name?.split(' ')[0]}</span>
                  <svg width="12" height="12" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6"/>
                  </svg>
                </button>
                {profileOpen && (
                  <div className="dropdown-menu">
                    <Link to="/profile" className="dropdown-item" onClick={() => setProfileOpen(false)}>
                      <svg width="14" height="14" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                      Profile
                    </Link>
                    <Link to="/my-tickets" className="dropdown-item" onClick={() => setProfileOpen(false)}>
                      <svg width="14" height="14" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
                      My Tickets
                    </Link>
                    <hr className="dropdown-divider" />
                    <button className="dropdown-item danger" onClick={handleLogout}>
                      <svg width="14" height="14" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                      Logout
                    </button>
                  </div>
                )}
              </div>
            ) : (
              <Link to="/login" className="btn-sign-in">Sign In</Link>
            )}
            <button className="hamburger" onClick={() => setMobileOpen(!mobileOpen)} aria-label="Menu">
              <span /><span /><span />
            </button>
          </div>
        </div>
      </nav>

      {/* Main nav menu */}
      <nav className={`main-nav ${mobileOpen ? 'mobile-open' : ''}`}>
        <div className="nav-container">
          <ul className="nav-links">
            <li><NavLink to="/" end onClick={() => setMobileOpen(false)}>🏠 Home</NavLink></li>
            <li><NavLink to="/events" onClick={() => setMobileOpen(false)}>📅 Events</NavLink></li>
            <li ref={catRef} className="has-dropdown">
              <button className="nav-dropdown-trigger" onClick={() => setCatOpen(!catOpen)}>
                ☰ Explore Categories
                <svg width="12" height="12" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
                  <path d="M6 9l6 6 6-6"/>
                </svg>
              </button>
              {catOpen && (
                <div className="nav-dropdown">
                  {categories.map((cat) => (
                    <Link
                      key={cat.id}
                      to={`/events?category=${cat.id}`}
                      className="nav-dropdown-item"
                      onClick={() => { setCatOpen(false); setMobileOpen(false) }}
                    >
                      {cat.name}
                    </Link>
                  ))}
                  <Link to="/categories" className="nav-dropdown-item all-cats" onClick={() => { setCatOpen(false); setMobileOpen(false) }}>
                    All Categories →
                  </Link>
                </div>
              )}
            </li>
            <li><NavLink to="/blogs" onClick={() => setMobileOpen(false)}>📄 Blogs</NavLink></li>
            <li><NavLink to="/contact" onClick={() => setMobileOpen(false)}>📞 Contact</NavLink></li>
            {isLoggedIn && (
              <li><NavLink to="/my-tickets" onClick={() => setMobileOpen(false)}>🎟 My Tickets</NavLink></li>
            )}
          </ul>
        </div>
      </nav>
    </header>
  )
}
