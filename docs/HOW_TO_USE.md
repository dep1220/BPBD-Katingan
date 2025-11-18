# 📖 HOW TO USE THIS DOCUMENTATION

## 🗂️ File Structure

```
docs/
├── .gitignore                      # Protects private docs from git
├── README.md                       # Navigation guide (PUBLIC)
├── API_DOCUMENTATION.md            # Complete API docs (PUBLIC)
├── SECURITY_IMPLEMENTATION.md      # Security details (PRIVATE)
├── DEPLOYMENT_NOTES.md             # Deployment guide (PRIVATE)
└── CREDENTIALS.md                  # Access credentials (PRIVATE)
```

---

## ✅ Public Files (Committed to Git)

### 1. README.md
- Overview dokumentasi
- Navigation guide
- Public information only

### 2. API_DOCUMENTATION.md
- Complete API reference
- All 11 modules, 54 endpoints
- Authentication flow
- Request/response examples
- Safe to share publicly

### 3. .gitignore
- Protects private files
- Ensures security

**These files WILL BE uploaded to GitHub ✅**

---

## 🔒 Private Files (NOT Committed)

### 1. SECURITY_IMPLEMENTATION.md
**Contains:**
- XSS Protection implementation details
- Rate limiting configuration
- Security headers setup
- File upload security
- CORS configuration
- Token expiration settings

**Why Private:**
- Reveals security mechanisms
- Shows attack prevention methods
- Could help attackers find vulnerabilities

### 2. DEPLOYMENT_NOTES.md
**Contains:**
- Server configuration details
- Apache/Nginx virtual host config
- Database setup commands
- SSH access procedures
- Backup strategies
- Cron job configurations

**Why Private:**
- Reveals server structure
- Shows system architecture
- Contains deployment procedures

### 3. CREDENTIALS.md
**Contains:**
- Admin usernames & passwords
- Database credentials
- SSH access details
- API keys
- SMTP credentials
- Third-party service tokens

**Why Private:**
- Critical security information
- Direct access credentials
- Could lead to system compromise

**These files will NOT BE uploaded to GitHub ❌**

---

## 🔐 How .gitignore Works

The `docs/.gitignore` file contains:

```gitignore
# Ignore security-sensitive documentation
SECURITY_IMPLEMENTATION.md
DEPLOYMENT_NOTES.md
CREDENTIALS.md

# Keep public documentation
!API_DOCUMENTATION.md
!README.md
```

**What happens:**
1. Git will track: `.gitignore`, `README.md`, `API_DOCUMENTATION.md`
2. Git will ignore: `SECURITY_IMPLEMENTATION.md`, `DEPLOYMENT_NOTES.md`, `CREDENTIALS.md`
3. Private files stay on your local machine/server only

---

## 📝 Usage Instructions

### For Developers

**When working locally:**
```bash
# All files are available
cd docs/
ls

# Output:
# .gitignore
# API_DOCUMENTATION.md
# README.md
# SECURITY_IMPLEMENTATION.md    ← You can see this
# DEPLOYMENT_NOTES.md            ← You can see this
# CREDENTIALS.md                 ← You can see this
```

**When committing to Git:**
```bash
git add docs/
git status

# Output shows only:
# new file:   docs/.gitignore
# new file:   docs/API_DOCUMENTATION.md
# new file:   docs/README.md
# 
# Private files are NOT listed! ✅
```

### For Public Access (GitHub)

**When someone clones the repo:**
```bash
git clone https://github.com/dep1220/BPBD-Katingan.git
cd BPBD-Katingan/docs/
ls

# They will only see:
# .gitignore
# API_DOCUMENTATION.md
# README.md
#
# They CANNOT see:
# SECURITY_IMPLEMENTATION.md    ← Not accessible
# DEPLOYMENT_NOTES.md            ← Not accessible
# CREDENTIALS.md                 ← Not accessible
```

---

## 🚀 Deployment to Server

### Step 1: Clone Repository (Public Files)
```bash
# On production server
git clone https://github.com/dep1220/BPBD-Katingan.git
cd BPBD-Katingan/docs/

# Only public files are cloned
```

### Step 2: Transfer Private Files Securely
```bash
# From local machine to server
# Use SCP (Secure Copy)
scp SECURITY_IMPLEMENTATION.md user@server:/var/www/bpbd-katingan/docs/
scp DEPLOYMENT_NOTES.md user@server:/var/www/bpbd-katingan/docs/
scp CREDENTIALS.md user@server:/var/www/bpbd-katingan/docs/

# Or use SFTP, rsync, or manual upload via FTP
```

### Step 3: Secure Private Files on Server
```bash
# Set proper permissions (read-only for owner)
chmod 600 docs/SECURITY_IMPLEMENTATION.md
chmod 600 docs/DEPLOYMENT_NOTES.md
chmod 600 docs/CREDENTIALS.md

# Verify
ls -la docs/
# Output should show:
# -rw------- 1 user user 11977 Nov 13 10:00 SECURITY_IMPLEMENTATION.md
# -rw------- 1 user user 11322 Nov 13 10:00 DEPLOYMENT_NOTES.md
# -rw------- 1 user user  7930 Nov 13 10:00 CREDENTIALS.md
```

---

## ⚠️ Important Warnings

### DO NOT:
❌ Remove `.gitignore` from docs folder
❌ Commit private files to git
❌ Push private files to GitHub
❌ Share private files publicly
❌ Store credentials in code
❌ Email private docs (use encrypted transfer)

### DO:
✅ Keep private files local only
✅ Transfer privately via secure methods
✅ Use strong passwords in CREDENTIALS.md
✅ Update private docs regularly
✅ Backup private files securely
✅ Limit access to authorized personnel

---

## 🔄 Updating Documentation

### Update Public Docs (API_DOCUMENTATION.md)
```bash
# Edit the file
nano docs/API_DOCUMENTATION.md

# Commit and push
git add docs/API_DOCUMENTATION.md
git commit -m "Update API documentation"
git push origin main
```

### Update Private Docs
```bash
# Edit locally
nano docs/CREDENTIALS.md

# NO git commands needed!
# File stays local automatically
```

---

## 🧪 Testing .gitignore

### Verify Private Files Are Ignored
```bash
# Try to add private file
git add docs/CREDENTIALS.md

# Check status
git status

# If working correctly, you should see:
# "The following paths are ignored by one of your .gitignore files"
```

### Force Check (Should Fail)
```bash
# Try to force add
git add -f docs/CREDENTIALS.md

# This WILL add the file (dangerous!)
# DON'T DO THIS unless absolutely necessary
```

---

## 📞 Questions?

### Can I share the private docs with team members?
**Yes, but securely:**
- Use encrypted email (GPG/PGP)
- Use secure file sharing (Password-protected)
- Use company internal network only
- Never via public channels

### What if I accidentally commit a private file?
**Immediately:**
```bash
# Remove from staging
git reset HEAD docs/CREDENTIALS.md

# If already committed (not pushed)
git reset --soft HEAD~1

# If already pushed (CRITICAL!)
# Contact all team members
# Change all credentials immediately
# Use git-filter-branch or BFG Repo-Cleaner
```

### How to backup private docs?
```bash
# Encrypt before backup
gpg -c docs/CREDENTIALS.md
# Creates: CREDENTIALS.md.gpg

# Store encrypted backup safely
# Keep encryption password secure
```

---

**Last Updated:** November 13, 2025
**Version:** 1.0

**🔒 Remember: Security is everyone's responsibility!**
