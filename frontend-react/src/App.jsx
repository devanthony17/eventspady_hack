import { Routes, Route } from 'react-router-dom'
import { useState, useEffect } from 'react'
import api from './api/api'
import Navbar from './components/layout/Navbar'
import Footer from './components/layout/Footer'
import ProtectedRoute from './components/ProtectedRoute'

// Pages
import Home from './pages/Home'
import Events from './pages/Events'
import EventDetail from './pages/EventDetail'
import AllCategories from './pages/AllCategories'
import Blog from './pages/Blog'
import BlogDetail from './pages/BlogDetail'
import OrganizerDetail from './pages/OrganizerDetail'
import Contact from './pages/Contact'
import Login from './pages/Login'
import Register from './pages/Register'
import Checkout from './pages/Checkout'
import Profile from './pages/Profile'
import MyTickets from './pages/MyTickets'
import NotFound from './pages/NotFound'

export default function App() {
  const [setting, setSetting] = useState(null)

  useEffect(() => {
    api.get('/user/setting').then((r) => setSetting(r.data?.data || null)).catch(() => {})
  }, [])

  return (
    <div className="app-root">
      <Navbar setting={setting} />
      <main className="main-content">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/events" element={<Events />} />
          <Route path="/event/:id/:slug" element={<EventDetail />} />
          <Route path="/event/:id" element={<EventDetail />} />
          <Route path="/categories" element={<AllCategories />} />
          <Route path="/blogs" element={<Blog />} />
          <Route path="/blog/:id/:slug" element={<BlogDetail />} />
          <Route path="/blog/:id" element={<BlogDetail />} />
          <Route path="/organizer/:id" element={<OrganizerDetail />} />
          <Route path="/contact" element={<Contact />} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />

          {/* Protected routes */}
          <Route path="/checkout/:eventId" element={<ProtectedRoute><Checkout /></ProtectedRoute>} />
          <Route path="/profile" element={<ProtectedRoute><Profile /></ProtectedRoute>} />
          <Route path="/my-tickets" element={<ProtectedRoute><MyTickets /></ProtectedRoute>} />

          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>
      <Footer setting={setting} />
    </div>
  )
}
