import { useState } from 'react'
import api from '../api/api'

export default function Contact() {
  const [form, setForm] = useState({ name: '', email: '', subject: '', message: '' })
  const [status, setStatus] = useState('')
  const [loading, setLoading] = useState(false)

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value })

  const handleSubmit = async (e) => {
    e.preventDefault()
    setLoading(true)
    setStatus('')
    try {
      await api.post('/user/contact', form)
      setStatus('success')
      setForm({ name: '', email: '', subject: '', message: '' })
    } catch {
      setStatus('error')
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="page-container" style={{ maxWidth: 760 }}>
      <div className="page-header">
        <h1>Contact Us</h1>
        <p>Have a question or feedback? We'd love to hear from you.</p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '2rem', marginBottom: '2.5rem', flexWrap: 'wrap' }}>
        {[
          { icon: '📧', label: 'Email', value: 'support@eventspady.com' },
          { icon: '📍', label: 'Location', value: 'Available Worldwide' },
        ].map((c) => (
          <div key={c.label} style={{ background: 'var(--bg-card)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', padding: '1.5rem', display: 'flex', gap: '1rem', alignItems: 'center' }}>
            <div style={{ fontSize: '2rem' }}>{c.icon}</div>
            <div>
              <p style={{ fontSize: '0.75rem', color: 'var(--text-muted)', marginBottom: '0.25rem', textTransform: 'uppercase', letterSpacing: '0.05em' }}>{c.label}</p>
              <p style={{ fontWeight: 600 }}>{c.value}</p>
            </div>
          </div>
        ))}
      </div>

      <div style={{ background: 'var(--bg-card)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', padding: '2rem' }}>
        <h2 style={{ fontSize: '1.1rem', fontWeight: 700, marginBottom: '1.5rem' }}>Send a Message</h2>

        {status === 'success' && (
          <div className="alert alert-success">✅ Message sent! We'll get back to you shortly.</div>
        )}
        {status === 'error' && (
          <div className="alert alert-error">❌ Something went wrong. Please try again.</div>
        )}

        <form onSubmit={handleSubmit}>
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
            <div className="form-group">
              <label className="form-label" htmlFor="contact-name">Full Name</label>
              <input id="contact-name" name="name" type="text" className="form-control" placeholder="John Doe" value={form.name} onChange={handleChange} required />
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="contact-email">Email Address</label>
              <input id="contact-email" name="email" type="email" className="form-control" placeholder="john@example.com" value={form.email} onChange={handleChange} required />
            </div>
          </div>
          <div className="form-group">
            <label className="form-label" htmlFor="contact-subject">Subject</label>
            <input id="contact-subject" name="subject" type="text" className="form-control" placeholder="How can we help?" value={form.subject} onChange={handleChange} required />
          </div>
          <div className="form-group">
            <label className="form-label" htmlFor="contact-message">Message</label>
            <textarea id="contact-message" name="message" className="form-control" placeholder="Write your message here..." value={form.message} onChange={handleChange} required />
          </div>
          <button type="submit" className="btn btn-primary" disabled={loading}>
            {loading ? 'Sending…' : 'Send Message ✉️'}
          </button>
        </form>
      </div>
    </div>
  )
}
