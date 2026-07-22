import { useState, useEffect, useRef } from 'react'
import { useAuth } from '../context/AuthContext'
import api from '../api/api'

export default function Profile() {
  const { user, updateUser } = useAuth()
  const [profile, setProfile] = useState(null)
  const [loading, setLoading] = useState(true)
  const [saving, setSaving] = useState(false)
  const [changingPass, setChangingPass] = useState(false)
  const [success, setSuccess] = useState('')
  const [error, setError] = useState('')
  const [form, setForm] = useState({ name: '', email: '', phone: '', about: '' })
  const [passForm, setPassForm] = useState({ old_password: '', new_password: '', new_password_confirmation: '' })
  const [activeTab, setActiveTab] = useState('profile')
  const fileRef = useRef()
  const imgBase = 'http://localhost:8000/images/upload/'

  useEffect(() => {
    api.get('/user/profile').then((r) => {
      const p = r.data?.data || {}
      setProfile(p)
      setForm({ name: p.name || '', email: p.email || '', phone: p.phone || '', about: p.about || '' })
    }).finally(() => setLoading(false))
  }, [])

  const handleChange = (e) => setForm({ ...form, [e.target.name]: e.target.value })
  const handlePassChange = (e) => setPassForm({ ...passForm, [e.target.name]: e.target.value })

  const handleSave = async (e) => {
    e.preventDefault()
    setSaving(true)
    setSuccess('')
    setError('')
    try {
      const res = await api.post('/user/edit-profile', form)
      updateUser(res.data?.data || form)
      setSuccess('Profile updated successfully.')
    } catch (err) {
      setError(err.response?.data?.message || 'Update failed.')
    } finally {
      setSaving(false)
    }
  }

  const handleImageChange = async (e) => {
    const file = e.target.files?.[0]
    if (!file) return
    const fd = new FormData()
    fd.append('image', file)
    try {
      const res = await api.post('/user/change-profile-image', fd, { headers: { 'Content-Type': 'multipart/form-data' } })
      const newImage = res.data?.data?.image
      if (newImage) { setProfile({ ...profile, image: newImage }); updateUser({ image: newImage }) }
      setSuccess('Profile image updated.')
    } catch { setError('Image upload failed.') }
  }

  const handleChangePass = async (e) => {
    e.preventDefault()
    if (passForm.new_password !== passForm.new_password_confirmation) { setError('New passwords do not match.'); return }
    setChangingPass(true)
    setSuccess('')
    setError('')
    try {
      await api.post('/user/change-password', passForm)
      setSuccess('Password changed successfully.')
      setPassForm({ old_password: '', new_password: '', new_password_confirmation: '' })
    } catch (err) {
      setError(err.response?.data?.message || 'Password change failed.')
    } finally {
      setChangingPass(false)
    }
  }

  if (loading) return <div className="spinner-wrap"><div className="spinner" /></div>

  const avatar = profile?.image
    ? `${imgBase}${profile.image}`
    : `https://ui-avatars.com/api/?name=${encodeURIComponent(profile?.name || 'User')}&size=120&background=6c63ff&color=fff`

  return (
    <div className="page-container" style={{ maxWidth: 860 }}>
      {/* Header */}
      <div style={{ background: 'var(--bg-card)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', padding: '2rem', marginBottom: '2rem', display: 'flex', gap: '1.5rem', alignItems: 'center', flexWrap: 'wrap' }}>
        <div style={{ position: 'relative' }}>
          <img src={avatar} alt={profile?.name} style={{ width: 90, height: 90, borderRadius: '50%', objectFit: 'cover', border: '3px solid var(--primary)' }} />
          <button
            onClick={() => fileRef.current?.click()}
            style={{ position: 'absolute', bottom: 0, right: 0, background: 'var(--primary)', border: 'none', borderRadius: '50%', width: 28, height: 28, fontSize: '0.75rem', color: '#fff', cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center' }}
            title="Change photo"
          >✏️</button>
          <input ref={fileRef} type="file" accept="image/*" style={{ display: 'none' }} onChange={handleImageChange} />
        </div>
        <div>
          <h1 style={{ fontSize: '1.5rem', fontWeight: 800, marginBottom: '0.25rem' }}>{profile?.name}</h1>
          <p style={{ color: 'var(--text-muted)', fontSize: '0.875rem' }}>{profile?.email}</p>
        </div>
      </div>

      {/* Tabs */}
      <div className="tabs">
        <button className={`tab-btn ${activeTab === 'profile' ? 'active' : ''}`} onClick={() => setActiveTab('profile')}>👤 Edit Profile</button>
        <button className={`tab-btn ${activeTab === 'password' ? 'active' : ''}`} onClick={() => setActiveTab('password')}>🔒 Change Password</button>
      </div>

      {success && <div className="alert alert-success">{success}</div>}
      {error && <div className="alert alert-error">{error}</div>}

      {/* Profile form */}
      {activeTab === 'profile' && (
        <div style={{ background: 'var(--bg-card)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', padding: '2rem' }}>
          <form onSubmit={handleSave}>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
              <div className="form-group">
                <label className="form-label" htmlFor="prof-name">Full Name</label>
                <input id="prof-name" name="name" type="text" className="form-control" value={form.name} onChange={handleChange} required />
              </div>
              <div className="form-group">
                <label className="form-label" htmlFor="prof-email">Email</label>
                <input id="prof-email" name="email" type="email" className="form-control" value={form.email} onChange={handleChange} required />
              </div>
              <div className="form-group">
                <label className="form-label" htmlFor="prof-phone">Phone</label>
                <input id="prof-phone" name="phone" type="tel" className="form-control" value={form.phone} onChange={handleChange} />
              </div>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="prof-about">About</label>
              <textarea id="prof-about" name="about" className="form-control" value={form.about} onChange={handleChange} placeholder="Tell us about yourself..." />
            </div>
            <button type="submit" className="btn btn-primary" disabled={saving}>{saving ? 'Saving…' : 'Save Changes'}</button>
          </form>
        </div>
      )}

      {/* Password form */}
      {activeTab === 'password' && (
        <div style={{ background: 'var(--bg-card)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', padding: '2rem' }}>
          <form onSubmit={handleChangePass}>
            <div className="form-group">
              <label className="form-label" htmlFor="old-pass">Current Password</label>
              <input id="old-pass" name="old_password" type="password" className="form-control" value={passForm.old_password} onChange={handlePassChange} required />
            </div>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
              <div className="form-group">
                <label className="form-label" htmlFor="new-pass">New Password</label>
                <input id="new-pass" name="new_password" type="password" className="form-control" value={passForm.new_password} onChange={handlePassChange} required />
              </div>
              <div className="form-group">
                <label className="form-label" htmlFor="conf-pass">Confirm New Password</label>
                <input id="conf-pass" name="new_password_confirmation" type="password" className="form-control" value={passForm.new_password_confirmation} onChange={handlePassChange} required />
              </div>
            </div>
            <button type="submit" className="btn btn-primary" disabled={changingPass}>{changingPass ? 'Updating…' : 'Update Password'}</button>
          </form>
        </div>
      )}
    </div>
  )
}
