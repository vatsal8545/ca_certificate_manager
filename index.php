<?php require_once 'auth_check.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Certificate Manager</title>
  <!-- Custom Premium Styles -->
  <link rel="stylesheet" href="assets/css/style.css?v=<?= time(); ?>">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
  <div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="brand-section">
        <div class="brand">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="color: #fbbf24;"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.622-.058-.006a2.89 2.89 0 0 0-3.322 3.322l.006.058-.622.622a2.89 2.89 0 0 0 0 4.134l.622.622-.006.058a2.89 2.89 0 0 0 3.322 3.322l.058-.006.622.622a2.89 2.89 0 0 0 4.134 0l.622-.622.058.006a2.89 2.89 0 0 0 3.322-3.322l-.006-.058.622-.622a2.89 2.89 0 0 0 0-4.134l-.622-.622.006-.058a2.89 2.89 0 0 0-3.322-3.322l-.058.006zm-5.69 2.477a1.89 1.89 0 0 1 2.174-2.174l.08.008.835-.835a1.89 1.89 0 0 1 2.67 0l.836.835.08-.008a1.89 1.89 0 0 1 2.174 2.174l-.008.08.835.836a1.89 1.89 0 0 1 0 2.67l-.835.835.008.08a1.89 1.89 0 0 1-2.174 2.174l-.08-.008-.835.835a1.89 1.89 0 0 1-2.67 0l-.836-.835-.08.008a1.89 1.89 0 0 1-2.174-2.174l.008-.08-.835-.836a1.89 1.89 0 0 1 0-2.67l.835-.835-.008-.08zm1.968 4.398a.5.5 0 0 0-.83.604l1.5 2.062a.5.5 0 0 0 .747.078l2.5-2.5a.5.5 0 0 0-.707-.708L7.75 9.423z"/></svg>
          CA CERT MANAGER
        </div>
        <p class="brand-subtitle">Simple • Fast • Accurate</p>
      </div>
      <nav class="nav-menu">
        <a class="nav-link-custom active" href="index.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4 0 1 1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
          Clients & Generator
        </a>
        <a class="nav-link-custom" href="firm_settings.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V1.1a.5.5 0 0 1 .278-.447l8-4a.5.5 0 0 1 .485.022M6 8.694 1.458 10.135A.5.5 0 0 0 1 10.615V15h8V8.694zM10 15h4V1.543l-7 3.5v9.957zm1.25-10a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5M11 7.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0M10.5 10a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1.5m0 2a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/></svg>
          Firm Settings
        </a>
        <a class="nav-link-custom" href="profile.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
          Profile
        </a>
      </nav>
      <div class="sidebar-footer">
        <div class="avatar" id="sidebarAvatar">A</div>
        <div class="user-info">
          <strong class="user-name" id="sidebarUser">admin</strong>
          <span class="user-role" id="sidebarRole">Administrator</span>
        </div>
        <a href="logout.php" class="logout-btn" title="Logout">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/><path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/></svg>
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="page-header">
        <div>
          <h1 class="page-title">Client & Certificate Generator</h1>
          <p class="page-subtitle">Manage your clients, import data, and generate certified financial documents.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <!-- Stats Widgets -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4 0 1 1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-value" id="statsTotalClients">0</span>
            <span class="stat-label">Total Clients</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-icon-success" id="statsFirmIcon">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V1.1a.5.5 0 0 1 .278-.447l8-4a.5.5 0 0 1 .485.022"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-value" id="statsFirmStatus">Not Configured</span>
            <span class="stat-label">CA Firm Status</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-icon-warning">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-value">5 Types</span>
            <span class="stat-label">Active Formats</span>
          </div>
        </div>
      </div>

      <!-- Top Editor Grid -->
      <div class="top-grid">
        <!-- Edit Client Form -->
        <div class="card-premium">
          <div class="card-header-premium">
            <h2 class="card-title-premium">
              <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="color: #2563eb;"><path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.002 6c.007-.166.059-.652.252-1.114.195-.47.5-.902.902-1.114.39-.208.824-.09 1.114.252.193.228.324.58.324.976v.382c0 .166-.024.32-.07.458a2 2 0 0 0-.254-.114 6 6 0 0 0-.252-.114 2 2 0 0 0-.902.114 2 2 0 0 0-.252.114 2 2 0 0 0-.252.114h-.358zM8 12c-4 0-5 3-5 4H2s0-4 6-4zm8-2v1.5a.5.5 0 0 1-.5.5h-1.5a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 .5.5"/></svg>
              Edit Client Details
            </h2>
            <button class="btn-custom btn-custom-secondary" id="newClientBtn" style="height:36px; padding:0 12px; font-size:0.8rem;">
              <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="margin-right:4px;"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
              New Client
            </button>
          </div>
          <div class="card-body-premium">
            <div class="form-grid">
              <div>
                <label for="clientNameInput" class="form-label-custom">Name of Client *</label>
                <input id="clientNameInput" type="text" class="form-control-custom" placeholder="Enter client name">
              </div>
              <div>
                <label for="clientStatusInput" class="form-label-custom">Status of Client *</label>
                <select id="clientStatusInput" class="form-control-custom">
                  <option value="Proprietor">Proprietor</option>
                  <option value="Firm">Firm</option>
                  <option value="Company">Company</option>
                  <option value="Individual">Individual</option>
                </select>
              </div>
              <div>
                <label for="panInput" class="form-label-custom">PAN Number *</label>
                <input id="panInput" type="text" class="form-control-custom" placeholder="ABCDE1234F">
              </div>
              <div>
                <label for="gstInput" class="form-label-custom">GST Number (if applicable)</label>
                <input id="gstInput" type="text" class="form-control-custom" placeholder="27ABCDE1234F1Z1">
              </div>
            </div>

            <!-- Financial Years & Values -->
            <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #f1f5f9;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 14px;">
                <h3 style="font-size: 0.88rem; color: #475569; font-weight: 700; text-transform: uppercase; letter-spacing:0.02em;">Financial Years & Amounts</h3>
                <button class="btn-custom btn-custom-secondary" id="addYearBtn" style="height:32px; padding:0 10px; font-size:0.75rem;">
                  + Add Year
                </button>
              </div>
              <div id="yearsContainer" class="years-container">
                <!-- Dynamic rows -->
              </div>
            </div>

            <!-- Summary Value -->
            <div class="summary-bar-custom">
              <span>Average Value:</span>
              <span class="summary-value-custom" id="avgAnnualValue">₹0</span>
            </div>

            <!-- Form Actions -->
            <div style="display:flex; gap:12px; margin-top:24px;">
              <button id="saveClientBtn" class="btn-custom btn-custom-primary">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                Save Client
              </button>
              <button id="clearFormBtn" class="btn-custom btn-custom-secondary">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.864 15H4a2 2 0 0 1-2-2V9.136a2 2 0 0 1 .586-1.414l5.5-5.5zM2 13h12a1 1 0 0 0 0-2H2a1 1 0 0 0 0 2z"/></svg>
                Clear Form
              </button>
            </div>
          </div>
        </div>

        <!-- Certificate Generator -->
        <div class="card-premium">
          <div class="card-header-premium">
            <h2 class="card-title-premium">
              <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="color: #ef4444;"><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/></svg>
              Certificate Generator
            </h2>
          </div>
          <div class="card-body-premium">
            <!-- Select type -->
            <div style="margin-bottom:20px;">
              <span class="form-label-custom">Select Certificate Type</span>
              <div style="display:flex; flex-direction:column; gap:10px; margin-top:8px;">
                <div class="cert-option-card active">
                  <input type="radio" name="certType" id="certTurnover" value="Turnover Certificate" checked>
                  <label for="certTurnover">Turnover Certificate</label>
                </div>
                <div class="cert-option-card">
                  <input type="radio" name="certType" id="certNetWorth" value="Net Worth Certificate">
                  <label for="certNetWorth">Net Worth Certificate</label>
                </div>
                <div class="cert-option-card">
                  <input type="radio" name="certType" id="certWorkingCapital" value="Working Capital Certificate">
                  <label for="certWorkingCapital">Working Capital Certificate</label>
                </div>
                <div class="cert-option-card">
                  <input type="radio" name="certType" id="certExistence" value="Existence Certificate">
                  <label for="certExistence">Existence Certificate</label>
                </div>
                <div class="cert-option-card">
                  <input type="radio" name="certType" id="certIncome" value="Income Declaration Certificate">
                  <label for="certIncome">Income Declaration Certificate</label>
                </div>
              </div>
            </div>

            <!-- Parameters fields -->
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:20px;">
              <div>
                <label for="certificateDateInput" class="form-label-custom">Date of Certificate *</label>
                <input id="certificateDateInput" type="date" class="form-control-custom">
              </div>
              <div>
                <label for="placeInput" class="form-label-custom">Place of Signing *</label>
                <select id="placeInput" class="form-control-custom">
                  <option value="">-- Select City --</option>
                  <option value="Ahmedabad">Ahmedabad</option>
                  <option value="Bangalore">Bangalore</option>
                  <option value="Mumbai">Mumbai</option>
                  <option value="Delhi">Delhi</option>
                  <option value="Pune">Pune</option>
                  <option value="Hyderabad">Hyderabad</option>
                  <option value="Chennai">Chennai</option>
                  <option value="Kolkata">Kolkata</option>
                  <option value="Jaipur">Jaipur</option>
                  <option value="Lucknow">Lucknow</option>
                  <option value="Surat">Surat</option>
                  <option value="Indore">Indore</option>
                  <option value="Vadodara">Vadodara</option>
                  <option value="Chandigarh">Chandigarh</option>
                  <option value="Bhopal">Bhopal</option>
                </select>
              </div>
              <div style="grid-column: span 2;">
                <label for="udinInput" class="form-label-custom">UDIN Number *</label>
                <input id="udinInput" type="text" class="form-control-custom" placeholder="25123456BMJXY1234">
              </div>
              <div style="grid-column: span 2;">
                <label for="templateStyleInput" class="form-label-custom">PDF Visual Template Theme *</label>
                <select id="templateStyleInput" class="form-control-custom">
                  <option value="Classic Navy">Classic Navy (Traditional Double-Border)</option>
                  <option value="Modern Corporate">Modern Corporate (Clean Minimalist)</option>
                  <option value="Elegant Gold">Elegant Gold (Luxury Amber Accents)</option>
                </select>
              </div>
            </div>

            <!-- Main buttons -->
            <div style="display:flex; flex-direction:column; gap:10px;">
              <button id="generatePdfBtn" class="btn-custom btn-custom-primary" style="width:100%;">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px;"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/><path d="M4.603 12.087a.08.08 0 0 1-.059-.014c-.093-.069-.062-.354.028-.688.08-.297.187-.565.3-.779-.244.362-.514.822-.269 1.482"/></svg>
                Download PDF Certificate
              </button>
              <button id="previewPrintBtn" class="btn-custom btn-custom-secondary" style="width:100%;">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:6px;"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
                Browser Print Preview
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Clients Database Panel -->
      <section class="card-premium">
        <div class="card-header-premium">
          <h2 class="card-title-premium">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="color: #10b981;"><path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0m0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-8-9c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
            Registered Clients Database
          </h2>
          <div style="display:flex; gap:10px; align-items:center;">
            <a href="sample_template.csv" class="btn-custom btn-custom-secondary" style="height:34px; padding:0 12px; font-size:0.8rem; text-decoration:none;" download>
              Sample CSV Template
            </a>
            <button class="btn-custom btn-custom-primary" id="importClientsBtn" style="height:34px; padding:0 12px; font-size:0.8rem;">
              Import CSV/Excel
            </button>
            <input id="clientImportInput" type="file" accept=".csv,.xlsx,.xls" hidden>
          </div>
        </div>
        <div class="card-body-premium">
          <!-- Custom Drag & Drop Zone -->
          <div class="upload-zone-custom" id="dropZone">
            <div class="upload-zone-icon">
              <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16" style="color:#2563eb;"><path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/><path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.79 2.22 12 3.781 12h8.906C13.98 12 15 11.002 15 9.773c0-1.152-.868-2.224-2.18-2.455l-.445-.078v-.45C12.375 4.3 10.428 3 8 3c-2.428 0-4.327 1.303-5.23 2.502L2.5 5.865v-.448c0-.616.396-1.403 1.153-2.056z"/></svg>
            </div>
            <h4 style="font-size: 0.95rem; font-weight:700; color: #0f172a; margin-bottom: 4px;">Drag and Drop Client Sheet here</h4>
            <p class="text-muted" style="font-size:0.8rem; margin:0;">Supports Excel (.xlsx, .xls) and CSV files. Columns match sample format.</p>
          </div>

          <div id="importStatus" class="import-status" style="display:none; margin-top:16px;"></div>

          <div class="table-responsive-custom">
            <table class="table-custom">
              <thead>
                <tr>
                  <th style="width: 25%">Name of Client</th>
                  <th style="width: 15%">Status</th>
                  <th style="width: 15%">PAN Number</th>
                  <th style="width: 15%">GST Number</th>
                  <th style="width: 20%">Financial Years Checked</th>
                  <th style="width: 10%">Actions</th>
                </tr>
              </thead>
              <tbody id="clientsTableBody"></tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- Excel Import Preview Modal -->
  <div class="custom-modal-overlay" id="importPreviewModal">
    <div class="custom-modal-container">
      <div class="custom-modal-header">
        <h3>Preview Imported Client Data</h3>
        <button class="custom-modal-close" id="closeModalBtn">&times;</button>
      </div>
      <div class="custom-modal-body">
        <p class="text-muted" style="font-size: 0.82rem; margin-bottom: 16px;">Review parsed rows before adding them to the database. Rows missing name or PAN will highlight in red.</p>
        <div class="table-responsive-custom" style="max-height: 400px; overflow-y: auto;">
          <table class="table-custom">
            <thead>
              <tr>
                <th style="width: 5%"><input type="checkbox" id="selectAllPreview" checked></th>
                <th style="width: 25%">Name</th>
                <th style="width: 15%">Status</th>
                <th style="width: 15%">PAN</th>
                <th style="width: 15%">GST</th>
                <th style="width: 25%">Parsed Financials</th>
              </tr>
            </thead>
            <tbody id="previewTableBody">
              <!-- JS populated -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="custom-modal-footer">
        <button type="button" class="btn-custom btn-custom-secondary" id="cancelImportBtn">Cancel</button>
        <button type="button" class="btn-custom btn-custom-primary" id="confirmImportBtn">
          Import Selected (<span id="importCount">0</span>)
        </button>
      </div>
    </div>
  </div>

  <!-- Hidden Form for Backend PDF download -->
  <form id="pdfGenerationForm" action="generate_certificate.php" method="POST" target="_blank" style="display:none;">
    <input type="hidden" name="client_data" id="pdfClientData">
    <input type="hidden" name="firm_data" id="pdfFirmData">
    <input type="hidden" name="cert_type" id="pdfCertType">
    <input type="hidden" name="cert_date" id="pdfCertDate">
    <input type="hidden" name="place" id="pdfPlace">
    <input type="hidden" name="udin" id="pdfUdin">
    <input type="hidden" name="template_style" id="pdfTemplateStyle">
  </form>

  <!-- SheetJS Excel Library -->
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.1/dist/xlsx.full.min.js"></script>

  <script>
    const clientsKey = 'ca_clients';
    const firmKey = 'ca_firm_settings';
    let editingId = null;
    let firmSettings = null;
    let currentImportList = [];

    const pageDate = document.getElementById('pageDate');
    const clientNameInput = document.getElementById('clientNameInput');
    const clientStatusInput = document.getElementById('clientStatusInput');
    const panInput = document.getElementById('panInput');
    const gstInput = document.getElementById('gstInput');
    const yearsContainer = document.getElementById('yearsContainer');
    const avgAnnualValue = document.getElementById('avgAnnualValue');
    const certificateDateInput = document.getElementById('certificateDateInput');
    const placeInput = document.getElementById('placeInput');
    const udinInput = document.getElementById('udinInput');
    const templateStyleInput = document.getElementById('templateStyleInput');
    const clientsTableBody = document.getElementById('clientsTableBody');

    const saveClientBtn = document.getElementById('saveClientBtn');
    const clearFormBtn = document.getElementById('clearFormBtn');
    const addYearBtn = document.getElementById('addYearBtn');
    const newClientBtn = document.getElementById('newClientBtn');
    const previewPrintBtn = document.getElementById('previewPrintBtn');
    const generatePdfBtn = document.getElementById('generatePdfBtn');
    const clientImportInput = document.getElementById('clientImportInput');
    const importClientsBtn = document.getElementById('importClientsBtn');
    const importStatus = document.getElementById('importStatus');
    const dropZone = document.getElementById('dropZone');

    const previewModalEl = document.getElementById('importPreviewModal');
    const previewTableBody = document.getElementById('previewTableBody');
    const selectAllPreview = document.getElementById('selectAllPreview');
    const confirmImportBtn = document.getElementById('confirmImportBtn');
    const importCountText = document.getElementById('importCount');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelImportBtn = document.getElementById('cancelImportBtn');

    // Sidebar User Session
    (function(){
      fetch('auth_session.php').then(r=>r.json()).then(data=>{
        if (data.user) {
          document.getElementById('sidebarUser').textContent = data.user.username;
          document.getElementById('sidebarRole').textContent = data.user.role;
          document.getElementById('sidebarAvatar').textContent = data.user.username.charAt(0).toUpperCase();
        }
      }).catch(()=>{});
    })();

    // Custom Radio Card triggers
    const certTypeRadios = document.querySelectorAll('[name="certType"]');
    certTypeRadios.forEach(radio => {
      radio.addEventListener('change', function() {
        certTypeRadios.forEach(r => r.closest('.cert-option-card').classList.remove('active'));
        if (this.checked) {
          this.closest('.cert-option-card').classList.add('active');
          adjustFormForCertType(this.value);
        }
      });
    });

    function adjustFormForCertType(type) {
      if (type === 'Net Worth Certificate') {
        yearsContainer.innerHTML = '';
        addFixedYearRow("Capital / Paid-up Capital");
        addFixedYearRow("Reserves & Surplus");
        avgAnnualValue.closest('.summary-bar-custom').querySelector('span:first-child').textContent = 'Total Net Worth:';
        updateSummary();
      } else if (type === 'Working Capital Certificate') {
        yearsContainer.innerHTML = '';
        addFixedYearRow("Current Assets");
        addFixedYearRow("Current Liabilities");
        avgAnnualValue.closest('.summary-bar-custom').querySelector('span:first-child').textContent = 'Net Working Capital:';
        updateSummary();
      } else {
        avgAnnualValue.closest('.summary-bar-custom').querySelector('span:first-child').textContent = 'Average Value:';
        const hasFixed = [...yearsContainer.querySelectorAll('.year-row-custom')].some(row => !row.querySelector('.year-field'));
        if (hasFixed || yearsContainer.innerHTML === '') {
          yearsContainer.innerHTML = '';
          addYearRow();
        }
        updateSummary();
      }
    }

    function addFixedYearRow(label) {
      const row = document.createElement('div');
      row.className = 'year-row-custom mb-2';
      row.innerHTML = `
        <span class="form-control-custom d-flex align-items-center bg-light border-0 fw-semibold" style="line-height:44px; display:inline-block; vertical-align:middle; background:#f1f5f9; font-weight:600; padding-left:12px;">${label}</span>
        <input type="number" class="form-control-custom amount-field" placeholder="Amount" value="">
        <span style="width:44px; display:inline-flex; align-items:center; justify-content:center; color:#94a3b8;">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg>
        </span>
      `;
      row.querySelector('.amount-field').addEventListener('input', updateSummary);
      yearsContainer.append(row);
    }

    function clearValidation($el) {
      $el.removeClass('is-invalid-custom');
      $el.next('.invalid-feedback-custom').remove();
    }

    function clearAllValidation() {
      $('.is-invalid-custom').removeClass('is-invalid-custom');
      $('.invalid-feedback-custom').remove();
    }

    function showValidationError($el, message) {
      clearValidation($el);
      $el.addClass('is-invalid-custom');
      $('<div class="invalid-feedback-custom"></div>').text(message).insertAfter($el);
    }

    function validateClientForm() {
      clearAllValidation();
      let valid = true;
      if (!clientNameInput.value.trim()) {
        showValidationError($(clientNameInput), 'Client name is required.');
        valid = false;
      }
      if (!panInput.value.trim()) {
        showValidationError($(panInput), 'PAN number is required.');
        valid = false;
      }
      const rows = [...yearsContainer.querySelectorAll('.year-row-custom')];
      if (!rows.length) {
        alert('Please add at least one financial record.');
        valid = false;
      }
      rows.forEach(row => {
        const $yearSelect = $(row).find('.year-field');
        const $amount = $(row).find('.amount-field');
        
        if ($yearSelect.length && $yearSelect.is('select') && !$yearSelect.val().trim()) {
          showValidationError($yearSelect, 'Year is required.');
          valid = false;
        }
        if (!$amount.val().trim() || Number($amount.val()) <= 0) {
          showValidationError($amount, 'Amount must be greater than zero.');
          valid = false;
        }
      });
      return valid;
    }

    function validatePreviewForm() {
      clearValidation($(certificateDateInput));
      clearValidation($(placeInput));
      clearValidation($(udinInput));
      let valid = true;
      if (!certificateDateInput.value) {
        showValidationError($(certificateDateInput), 'Certificate date is required.');
        valid = false;
      }
      if (!placeInput.value.trim()) {
        showValidationError($(placeInput), 'Place of signing is required.');
        valid = false;
      }
      if (!udinInput.value.trim()) {
        showValidationError($(udinInput), 'UDIN number is required.');
        valid = false;
      }
      return valid;
    }

    $(yearsContainer).on('input', '.year-field, .amount-field', function() {
      clearValidation($(this));
    });
    $('input, select').on('input change', function() {
      clearValidation($(this));
    });

    function formatDateDisplay(value) {
      const date = new Date(value);
      return date.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    function loadFirmSettings() {
      const saved = localStorage.getItem(firmKey);
      const parsed = saved ? JSON.parse(saved) : null;
      firmSettings = parsed;
      
      const statsFirmStatus = document.getElementById('statsFirmStatus');
      const statsFirmIcon = document.getElementById('statsFirmIcon');
      if (parsed) {
        statsFirmStatus.textContent = parsed.firmName;
        statsFirmStatus.className = "stat-value fs-6 text-truncate";
        statsFirmIcon.className = "stat-icon stat-icon-success";
        if (parsed.udin && !udinInput.value) {
          udinInput.value = parsed.udin;
        }
      } else {
        statsFirmStatus.textContent = "Not Configured";
        statsFirmStatus.className = "stat-value";
        statsFirmIcon.className = "stat-icon stat-icon-warning";
      }
      return parsed;
    }

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + formatDateDisplay(today.toISOString().slice(0,10));
      certificateDateInput.value = today.toISOString().slice(0,10);
    }

    function loadClients() {
      const list = JSON.parse(localStorage.getItem(clientsKey) || '[]');
      document.getElementById('statsTotalClients').textContent = list.length;
      return list;
    }

    function saveClients(clients) {
      localStorage.setItem(clientsKey, JSON.stringify(clients));
      loadClients();
      renderClientsTable();
    }

    function showImportStatus(message, isError = false) {
      if (!importStatus) return;
      importStatus.style.display = 'block';
      importStatus.textContent = message;
      importStatus.className = 'import-status alert ' + (isError ? 'alert-danger' : 'alert-success');
      setTimeout(() => {
        importStatus.style.display = 'none';
      }, 5000);
    }

    function normalizeHeader(value) {
      if (value === null || value === undefined) return '';
      const normalized = String(value).toLowerCase().trim().replace(/[^a-z0-9]+/g, ' ');
      const headerMap = {
        'client name': 'clientName',
        'name of client': 'clientName',
        'client': 'clientName',
        'name': 'clientName',
        'status': 'status',
        'status of client': 'status',
        'client status': 'status',
        'pan number': 'pan',
        'pan': 'pan',
        'gst number': 'gst',
        'gst': 'gst',
        'gstin': 'gst',
        'financial year': 'financialYear',
        'financial years checked': 'financialYear',
        'financial years': 'financialYear',
        'year': 'financialYear',
        'amount': 'amount',
        'turnover': 'amount',
        'value': 'amount'
      };
      return headerMap[normalized] || normalized.replace(/\s+/g, '');
    }

    function normalizeValue(value) {
      if (value === null || value === undefined) return '';
      return String(value).trim();
    }

    function parseImportedRows(workbook) {
      const sheet = workbook.Sheets[workbook.SheetNames[0]];
      const rows = XLSX.utils.sheet_to_json(sheet, { defval: '', raw: false });
      if (!Array.isArray(rows) || !rows.length) return [];
      return rows
        .map(row => {
          const normalizedRow = {};
          Object.keys(row).forEach(key => {
            normalizedRow[normalizeHeader(key)] = normalizeValue(row[key]);
          });
          return normalizedRow;
        })
        .filter(row => Object.values(row).some(value => String(value).trim()));
    }

    async function handleFileSelected(file) {
      if (!file) return;
      const extension = file.name.split('.').pop()?.toLowerCase();
      if (!['csv', 'xls', 'xlsx'].includes(extension || '')) {
        showImportStatus('Please upload a CSV or Excel file.', true);
        return;
      }

      try {
        const arrayBuffer = await file.arrayBuffer();
        const workbook = XLSX.read(arrayBuffer, { type: 'array' });
        const rawRows = parseImportedRows(workbook);
        if (!rawRows.length) {
          showImportStatus('No usable rows were found in the file.', true);
          return;
        }

        const grouped = {};
        rawRows.forEach((row, idx) => {
          const name = row.clientName || '';
          const pan = (row.pan || '').toUpperCase();
          const key = pan || name.toLowerCase();
          
          if (!name) return;
          
          if (!grouped[key]) {
            grouped[key] = {
              id: `imported-${Date.now()}-${idx}`,
              name: name,
              status: row.status || 'Proprietor',
              pan: pan,
              gst: (row.gst || '').toUpperCase(),
              years: []
            };
          }
          
          const year = row.financialYear || '';
          const amount = row.amount || '';
          if (year && amount) {
            grouped[key].years.push({ year, amount });
          }
        });

        currentImportList = Object.values(grouped);
        renderImportPreview();
        previewModalEl.classList.add('show');
        if (clientImportInput) {
          clientImportInput.value = '';
        }
      } catch (err) {
        console.error(err);
        showImportStatus('The file could not be parsed. Check columns formatting.', true);
      }
    }

    function renderImportPreview() {
      if (!currentImportList.length) {
        previewTableBody.innerHTML = '<tr><td colspan="6" class="text-center p-4">No clients parsed successfully.</td></tr>';
        confirmImportBtn.disabled = true;
        importCountText.textContent = '0';
        return;
      }

      const existingClients = loadClients();
      confirmImportBtn.disabled = false;

      previewTableBody.innerHTML = currentImportList.map((client, index) => {
        const isDuplicate = existingClients.some(ec => ec.pan && client.pan && ec.pan.toLowerCase() === client.pan.toLowerCase());
        const hasWarning = !client.pan;
        
        let rowStyle = '';
        if (hasWarning) rowStyle = 'background-color:#fef2f2;';
        else if (isDuplicate) rowStyle = 'background-color:#fffbeb;';

        let statusBadge = '';
        if (hasWarning) statusBadge = '<span class="badge-custom" style="background:#fef2f2; color:#ef4444; border-color:#fee2e2;">Missing PAN</span>';
        else if (isDuplicate) statusBadge = '<span class="badge-custom" style="background:#fffbeb; color:#d97706; border-color:#fef3c7;">Duplicate (Will Update)</span>';
        else statusBadge = '<span class="badge-custom" style="background:#f0fdf4; color:#166534; border-color:#bbf7d0;">Ready</span>';

        const yearsDesc = client.years.map(y => `${y.year} (₹${Number(y.amount).toLocaleString('en-IN')})`).join(', ') || 'No FY details';

        return `
          <tr style="${rowStyle}">
            <td>
              <input type="checkbox" class="preview-select-checkbox" data-index="${index}" ${hasWarning ? '' : 'checked'}>
            </td>
            <td>
              <div class="fw-bold">${client.name}</div>
              <div class="mt-1">${statusBadge}</div>
            </td>
            <td>${client.status}</td>
            <td class="font-monospace">${client.pan || '-'}</td>
            <td class="font-monospace">${client.gst || '-'}</td>
            <td class="small">${yearsDesc}</td>
          </tr>
        `;
      }).join('');

      updateImportCount();
    }

    function updateImportCount() {
      const checkedBoxes = previewTableBody.querySelectorAll('.preview-select-checkbox:checked');
      importCountText.textContent = checkedBoxes.length;
      confirmImportBtn.disabled = checkedBoxes.length === 0;
    }

    selectAllPreview.addEventListener('change', function() {
      const checkboxes = previewTableBody.querySelectorAll('.preview-select-checkbox');
      checkboxes.forEach(cb => {
        if (!cb.disabled) {
          cb.checked = this.checked;
        }
      });
      updateImportCount();
    });

    previewTableBody.addEventListener('change', function(e) {
      if (e.target.classList.contains('preview-select-checkbox')) {
        updateImportCount();
      }
    });

    confirmImportBtn.addEventListener('click', function() {
      const checkboxes = previewTableBody.querySelectorAll('.preview-select-checkbox:checked');
      if (!checkboxes.length) return;

      const clients = loadClients();
      let importedCount = 0;

      checkboxes.forEach(cb => {
        const index = cb.getAttribute('data-index');
        const importedClient = currentImportList[index];

        const existingIndex = clients.findIndex(c => c.pan && importedClient.pan && c.pan.toLowerCase() === importedClient.pan.toLowerCase());

        if (existingIndex >= 0) {
          const ec = clients[existingIndex];
          ec.name = importedClient.name;
          ec.status = importedClient.status;
          ec.gst = importedClient.gst || ec.gst;
          
          importedClient.years.forEach(iy => {
            const hasYear = ec.years.some(ey => ey.year === iy.year);
            if (!hasYear) {
              ec.years.push(iy);
            } else {
              const yIdx = ec.years.findIndex(ey => ey.year === iy.year);
              ec.years[yIdx].amount = iy.amount;
            }
          });
        } else {
          clients.unshift(importedClient);
        }
        importedCount++;
      });

      saveClients(clients);
      previewModalEl.classList.remove('show');
      showImportStatus(`Imported and updated ${importedCount} client record(s) successfully!`);
    });

    // Close preview modal functions
    const hideModal = () => previewModalEl.classList.remove('show');
    closeModalBtn.addEventListener('click', hideModal);
    cancelImportBtn.addEventListener('click', hideModal);

    // Drag & Drop Setup
    dropZone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropZone.style.borderColor = '#2563eb';
      dropZone.style.backgroundColor = '#eff6ff';
    });
    dropZone.addEventListener('dragleave', () => {
      dropZone.style.borderColor = '#cbd5e1';
      dropZone.style.backgroundColor = '#f8fafc';
    });
    dropZone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropZone.style.borderColor = '#cbd5e1';
      dropZone.style.backgroundColor = '#f8fafc';
      const file = e.dataTransfer.files?.[0];
      if (file) {
        handleFileSelected(file);
      }
    });

    dropZone.addEventListener('click', () => {
      clientImportInput.click();
    });

    clientImportInput.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (file) {
        handleFileSelected(file);
      }
    });

    if (importClientsBtn) {
      importClientsBtn.addEventListener('click', () => clientImportInput.click());
    }

    function createYearRow(year = '', amount = '') {
      const row = document.createElement('div');
      row.className = 'year-row-custom mb-2';
      
      const currentYear = new Date().getFullYear();
      const yearOptions = [];
      for (let i = currentYear; i >= currentYear - 15; i--) {
        const fy = `${i}-${String(i + 1).slice(-2)}`;
        yearOptions.push(`<option value="${fy}" ${fy === year ? 'selected' : ''}>${fy}</option>`);
      }
      
      row.innerHTML = `
        <select class="form-control-custom year-field">
          <option value="">-- Select Year --</option>
          ${yearOptions.join('')}
        </select>
        <input type="number" class="form-control-custom amount-field" placeholder="Amount" value="${amount}">
        <button type="button" class="year-remove-btn" title="Remove row">×</button>
      `;
      
      row.querySelector('.year-remove-btn').addEventListener('click', () => {
        row.remove();
        updateSummary();
      });
      row.querySelector('.year-field').addEventListener('change', updateSummary);
      row.querySelector('.amount-field').addEventListener('input', updateSummary);
      return row;
    }

    function updateSummary() {
      const rows = [...yearsContainer.querySelectorAll('.year-row-custom')];
      const amounts = rows
        .map(row => Number(row.querySelector('.amount-field').value) || 0)
        .filter(value => value > 0);
      
      const type = getSelectedCertificateType();
      
      if (type === 'Net Worth Certificate') {
        const paidUp = Number(rows[0]?.querySelector('.amount-field').value) || 0;
        const reserves = Number(rows[1]?.querySelector('.amount-field').value) || 0;
        const netWorth = paidUp + reserves;
        avgAnnualValue.textContent = '₹' + netWorth.toLocaleString('en-IN');
        return;
      }
      
      if (type === 'Working Capital Certificate') {
        const assets = Number(rows[0]?.querySelector('.amount-field').value) || 0;
        const liabilities = Number(rows[1]?.querySelector('.amount-field').value) || 0;
        const wc = assets - liabilities;
        avgAnnualValue.textContent = '₹' + wc.toLocaleString('en-IN');
        return;
      }

      if (!amounts.length) {
        avgAnnualValue.textContent = '₹0';
        return;
      }
      const average = Math.round(amounts.reduce((sum, value) => sum + value, 0) / amounts.length);
      avgAnnualValue.textContent = '₹' + average.toLocaleString('en-IN');
    }

    function addYearRow(year = '', amount = '') {
      const certType = getSelectedCertificateType();
      if (certType === 'Net Worth Certificate' || certType === 'Working Capital Certificate') {
        return;
      }
      yearsContainer.append(createYearRow(year, amount));
      updateSummary();
    }

    function resetClientForm() {
      editingId = null;
      clientNameInput.value = '';
      clientStatusInput.value = 'Proprietor';
      panInput.value = '';
      gstInput.value = '';
      yearsContainer.innerHTML = '';
      adjustFormForCertType(getSelectedCertificateType());
      updateSummary();
    }

    function getSelectedCertificateType() {
      const checked = [...certTypeRadios].find(radio => radio.checked);
      return checked ? checked.value : 'Turnover Certificate';
    }

    function getClientDataFromForm() {
      const rows = [...yearsContainer.querySelectorAll('.year-row-custom')];
      const type = getSelectedCertificateType();
      
      let yearsData = [];
      if (type === 'Net Worth Certificate' || type === 'Working Capital Certificate') {
        yearsData = rows.map((row, idx) => ({
          year: idx === 0 ? 'Capital' : (type === 'Net Worth Certificate' ? 'Reserves' : 'Liabilities'),
          amount: row.querySelector('.amount-field').value.trim()
        }));
      } else {
        yearsData = rows.map(row => ({
          year: row.querySelector('.year-field').value.trim(),
          amount: row.querySelector('.amount-field').value.trim()
        })).filter(row => row.year && row.amount);
      }

      return {
        id: editingId || Date.now().toString(),
        name: clientNameInput.value.trim(),
        status: clientStatusInput.value,
        pan: panInput.value.trim().toUpperCase(),
        gst: gstInput.value.trim().toUpperCase(),
        years: yearsData
      };
    }

    function saveCurrentClient() {
      if (!validateClientForm()) {
        return;
      }
      const clients = loadClients();
      const client = getClientDataFromForm();
      const existingIndex = clients.findIndex(item => item.id === client.id);
      if (existingIndex >= 0) {
        clients[existingIndex] = client;
      } else {
        clients.unshift(client);
      }
      saveClients(clients);
      resetClientForm();
    }

    function renderClientsTable() {
      const clients = loadClients();
      if (!clients.length) {
        clientsTableBody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted"><p class="mt-2 mb-0">No clients registered yet.</p></td></tr>';
        return;
      }
      clientsTableBody.innerHTML = clients.map(client => {
        const yearsWithAmounts = client.years.map(item => `${item.year} (₹${Number(item.amount).toLocaleString('en-IN')})`).join(', ');
        
        let statusBadgeClass = 'badge-custom';
        const st = client.status.toLowerCase();
        if (st === 'company') statusBadgeClass += ' badge-company';
        else if (st === 'firm') statusBadgeClass += ' badge-firm';
        else if (st === 'proprietor') statusBadgeClass += ' badge-proprietor';
        else if (st === 'individual') statusBadgeClass += ' badge-individual';

        return `
          <tr>
            <td class="fw-semibold text-dark">${client.name}</td>
            <td><span class="${statusBadgeClass}">${client.status}</span></td>
            <td class="font-monospace">${client.pan}</td>
            <td class="font-monospace">${client.gst || '-'}</td>
            <td class="small text-muted">${yearsWithAmounts || '-'}</td>
            <td>
              <div style="display:flex; gap:6px;">
                <button class="btn-custom btn-custom-secondary" style="height:32px; padding:0 8px;" onclick="editClient('${client.id}')" title="Edit">
                  <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.5-.5H1.498 1.5v.5A.5.5 0 0 1 1 11h-.5a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h.842l.842-.842c.07-.07.16-.118.258-.138l.842-.168A1.5 1.5 0 0 1 3.5 8.5H4v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l.854-.854c.098-.098.146-.24.138-.378l-.168-.842a1.5 1.5 0 0 1-.138-.258l-.842-.842z"/></svg>
                </button>
                <button class="btn-custom btn-custom-primary" style="height:32px; padding:0 8px;" onclick="selectClient('${client.id}')" title="Select for Certificate">
                  <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z"/></svg>
                </button>
                <button class="btn-custom btn-custom-danger" style="height:32px; padding:0 8px;" onclick="deleteClient('${client.id}')" title="Delete">
                  <svg width="12" height="12" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
                </button>
              </div>
            </td>
          </tr>`;
      }).join('');
    }

    function editClient(id) {
      const clients = loadClients();
      const client = clients.find(item => item.id === id);
      if (!client) return;
      editingId = client.id;
      clientNameInput.value = client.name;
      clientStatusInput.value = client.status;
      panInput.value = client.pan;
      gstInput.value = client.gst;
      yearsContainer.innerHTML = '';
      
      const certType = getSelectedCertificateType();
      
      if (certType === 'Net Worth Certificate' || certType === 'Working Capital Certificate') {
        adjustFormForCertType(certType);
        const rows = [...yearsContainer.querySelectorAll('.year-row-custom')];
        client.years.forEach((y, idx) => {
          if (rows[idx]) {
            rows[idx].querySelector('.amount-field').value = y.amount;
          }
        });
      } else {
        client.years.forEach(year => addYearRow(year.year, year.amount));
      }
      updateSummary();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function selectClient(id) {
      editClient(id);
    }

    function deleteClient(id) {
      if (confirm('Are you sure you want to delete this client record?')) {
        const clients = loadClients().filter(item => item.id !== id);
        saveClients(clients);
      }
    }

    function getYearRows() {
      const rows = [...yearsContainer.querySelectorAll('.year-row-custom')];
      const type = getSelectedCertificateType();
      if (type === 'Net Worth Certificate' || type === 'Working Capital Certificate') {
        return rows.map((row, idx) => ({
          year: idx === 0 ? 'Capital' : (type === 'Net Worth Certificate' ? 'Reserves' : 'Liabilities'),
          amount: row.querySelector('.amount-field').value.trim()
        }));
      }
      return rows.map(row => ({
        year: row.querySelector('.year-field').value.trim(),
        amount: row.querySelector('.amount-field').value.trim()
      })).filter(item => item.year && item.amount);
    }

    function toIndianWords(num) {
      const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
      const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
      if (num === 0) return 'Zero';
      if (num < 20) return a[num];
      if (num < 100) return b[Math.floor(num / 10)] + (num % 10 ? ' ' + a[num % 10] : '');
      if (num < 1000) return a[Math.floor(num / 100)] + ' Hundred' + (num % 100 ? ' ' + toIndianWords(num % 100) : '');
      if (num < 100000) return toIndianWords(Math.floor(num / 1000)) + ' Thousand' + (num % 1000 ? ' ' + toIndianWords(num % 1000) : '');
      if (num < 10000000) return toIndianWords(Math.floor(num / 100000)) + ' Lakh' + (num % 100000 ? ' ' + toIndianWords(num % 100000) : '');
      return toIndianWords(Math.floor(num / 10000000)) + ' Crore' + (num % 10000000 ? ' ' + toIndianWords(num % 10000000) : '');
    }

    function amountInWords(value) {
      const amount = Number(value) || 0;
      const integerPart = Math.floor(amount);
      const words = toIndianWords(integerPart);
      return words + ' Rupees Only';
    }

    function renderCertificateHtml(type, client, firm, dateValue, place, udin, yearsRows) {
      const firmNameText = firm?.firmName || '[Name of your CA Firm]';
      const firmFrnText = firm?.frn || '[FRN Number]';
      const firmSignatory = firm?.signatoryName || '[Your Name]';
      const firmSignatoryStatus = firm?.signatoryStatus || 'Proprietor';
      const firmMembership = firm?.membershipNumber || '[Membership No]';
      const firmUdinText = firm?.udin || udin || '[UDIN]';

      const style = templateStyleInput.value;
      let primaryColor = '#1e3a8a';
      let fontName = "Georgia, serif";
      let borderLayout = "border: 4px double #1e3a8a;";
      if (style === 'Modern Corporate') {
        primaryColor = '#334155';
        fontName = "Arial, sans-serif";
        borderLayout = "border: 1px solid #cbd5e1;";
      } else if (style === 'Elegant Gold') {
        primaryColor = '#b45309';
        fontName = "Garamond, serif";
        borderLayout = "border: 2px solid #b45309;";
      }

      const header = `
        <div style="text-align:center;margin-bottom:24px;">
          <div style="font-size:0.9rem;letter-spacing:0.2em;color:#475569;font-weight:700;">TO WHOMSOEVER IT MAY CONCERN</div>
          <h1 style="margin:14px 0 6px;font-size:1.6rem;color:${primaryColor};">${type.toUpperCase()}</h1>
        </div>`;

      const firmHeader = `
        <div style="text-align:center;margin-bottom:18px;border-bottom:1px solid #e2e8f0;padding-bottom:12px;">
          <div style="font-size:1.2rem;font-weight:700;color:${primaryColor};text-transform:uppercase;">${firmNameText}</div>
          <div style="font-size:0.85rem;color:#475569;font-weight:700;letter-spacing:1px;">Chartered Accountants</div>
          <div style="font-size:0.8rem;color:#64748b;margin-top:2px;">FRN: ${firmFrnText} | M. No: ${firmMembership}</div>
        </div>`;

      const gstPhrase = client.gst ? ` and GSTIN <strong>${client.gst}</strong>` : '';
      const basicIntro = `
        <p style="line-height:1.7;color:#0f172a;">We, <strong>${firmNameText}</strong>, Chartered Accountants, have examined the books of accounts and records of <strong>${client.name}</strong> (${client.status}), holding PAN <strong>${client.pan}</strong>${gstPhrase}, and certify the details below:</p>`;

      if (type === 'Turnover Certificate') {
        const rowsHtml = yearsRows.map(row => `
            <tr>
              <td style="padding:10px;border:1px solid #cbd5e1;">${row.year}</td>
              <td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${Number(row.amount).toLocaleString('en-IN')}</td>
              <td style="padding:10px;border:1px solid #cbd5e1;">${amountInWords(row.amount)}</td>
            </tr>`).join('');
        const average = yearsRows.reduce((sum, row) => sum + (Number(row.amount) || 0), 0) / (yearsRows.length || 1);
        return `
          <div style="${borderLayout}padding:30px;font-family:${fontName};">
            ${firmHeader}
            ${header}
            ${basicIntro}
            <table style="width:100%;border-collapse:collapse;margin-top:15px;font-size:0.9rem;">
              <thead>
                <tr style="background:${primaryColor};color:#fff;text-align:left;">
                  <th style="padding:10px;border:1px solid #cbd5e1;">Financial Year</th>
                  <th style="padding:10px;border:1px solid #cbd5e1;text-align:right;">Turnover (in INR)</th>
                  <th style="padding:10px;border:1px solid #cbd5e1;">Turnover (in Words)</th>
                </tr>
              </thead>
              <tbody>${rowsHtml}</tbody>
            </table>
            <p style="margin-top:18px;line-height:1.7;color:#0f172a;"><strong>Average Annual Turnover:</strong> The average annual turnover of the entity for the above-mentioned financial years is INR <strong>₹${Math.round(average).toLocaleString('en-IN')}</strong> (${amountInWords(Math.round(average))}).</p>
          </div>`;
      }

      if (type === 'Net Worth Certificate') {
        const paidUp = Number(yearsRows[0]?.amount || 0);
        const reserves = Number(yearsRows[1]?.amount || 0);
        const netWorth = paidUp + reserves;
        return `
          <div style="${borderLayout}padding:30px;font-family:${fontName};">
            ${firmHeader}
            ${header}
            ${basicIntro}
            <p style="line-height:1.7;color:#0f172a;">Based on the balance sheet and financial records as on <strong>${formatDateDisplay(dateValue)}</strong>, the Net Worth is certified below:</p>
            <table style="width:100%;border-collapse:collapse;margin-top:15px;font-size:0.9rem;">
              <thead>
                <tr style="background:${primaryColor};color:#fff;text-align:left;">
                  <th style="padding:10px;border:1px solid #cbd5e1;">Particulars</th>
                  <th style="padding:10px;border:1px solid #cbd5e1;text-align:right;">Amount (₹)</th>
                </tr>
              </thead>
              <tbody>
                <tr><td style="padding:10px;border:1px solid #cbd5e1;">(A) Paid-up Share Capital / Owner's Capital</td><td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${paidUp.toLocaleString('en-IN')}</td></tr>
                <tr><td style="padding:10px;border:1px solid #cbd5e1;">(B) Reserves & Surplus</td><td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${reserves.toLocaleString('en-IN')}</td></tr>
                <tr style="background:#f8fafc;font-weight:bold;"><td style="padding:10px;border:1px solid #cbd5e1;">Net Worth (A + B)</td><td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${netWorth.toLocaleString('en-IN')}</td></tr>
              </tbody>
            </table>
            <p style="margin-top:18px;line-height:1.7;color:#0f172a;">The Net Worth of the entity as on the certified date is <strong>₹${netWorth.toLocaleString('en-IN')}</strong> (${amountInWords(netWorth)}).</p>
          </div>`;
      }

      if (type === 'Working Capital Certificate') {
        const currentAssets = Number(yearsRows[0]?.amount || 0);
        const currentLiabilities = Number(yearsRows[1]?.amount || 0);
        const workingCapital = currentAssets - currentLiabilities;
        return `
          <div style="${borderLayout}padding:30px;font-family:${fontName};">
            ${firmHeader}
            ${header}
            ${basicIntro}
            <p style="line-height:1.7;color:#0f172a;">Based on the balance sheet and financial records as on <strong>${formatDateDisplay(dateValue)}</strong>, the Working Capital position is certified below:</p>
            <table style="width:100%;border-collapse:collapse;margin-top:15px;font-size:0.9rem;">
              <thead>
                <tr style="background:${primaryColor};color:#fff;text-align:left;">
                  <th style="padding:10px;border:1px solid #cbd5e1;">Particulars</th>
                  <th style="padding:10px;border:1px solid #cbd5e1;text-align:right;">Amount (₹)</th>
                </tr>
              </thead>
              <tbody>
                <tr><td style="padding:10px;border:1px solid #cbd5e1;">(A) Current Assets</td><td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${currentAssets.toLocaleString('en-IN')}</td></tr>
                <tr><td style="padding:10px;border:1px solid #cbd5e1;">(B) Current Liabilities</td><td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${currentLiabilities.toLocaleString('en-IN')}</td></tr>
                <tr style="background:#f8fafc;font-weight:bold;"><td style="padding:10px;border:1px solid #cbd5e1;">Working Capital (A - B)</td><td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${workingCapital.toLocaleString('en-IN')}</td></tr>
              </tbody>
            </table>
            <p style="margin-top:18px;line-height:1.7;color:#0f172a;">The Net Working Capital of the entity as on the certified date is <strong>₹${workingCapital.toLocaleString('en-IN')}</strong> (${amountInWords(workingCapital)}).</p>
          </div>`;
      }

      if (type === 'Existence Certificate') {
        return `
          <div style="${borderLayout}padding:30px;font-family:${fontName};">
            ${firmHeader}
            ${header}
            <p style="line-height:1.8;color:#0f172a;text-align:justify;font-size:1rem;margin-top:20px;">This is to certify that <strong>${client.name}</strong>, a registered <strong>${client.status}</strong>, holding PAN <strong>${client.pan}</strong>${gstPhrase}, is active, in existence and operational as on <strong>${formatDateDisplay(dateValue)}</strong>.</p>
            <p style="line-height:1.8;color:#0f172a;text-align:justify;font-size:1rem;margin-top:15px;">We have verified the operational status of the client based on trade licences, tax registration details, computation tables, and corporate registries produced before us.</p>
          </div>`;
      }

      if (type === 'Income Declaration Certificate') {
        const rowsHtml = yearsRows.map(row => `
            <tr>
              <td style="padding:10px;border:1px solid #cbd5e1;">${row.year}</td>
              <td style="padding:10px;border:1px solid #cbd5e1;text-align:right;">₹${Number(row.amount).toLocaleString('en-IN')}</td>
              <td style="padding:10px;border:1px solid #cbd5e1;">${amountInWords(row.amount)}</td>
            </tr>`).join('');
        return `
          <div style="${borderLayout}padding:30px;font-family:${fontName};">
            ${firmHeader}
            ${header}
            ${basicIntro}
            <table style="width:100%;border-collapse:collapse;margin-top:15px;font-size:0.9rem;">
              <thead>
                <tr style="background:${primaryColor};color:#fff;text-align:left;">
                  <th style="padding:10px;border:1px solid #cbd5e1;">Assessment Year / FY</th>
                  <th style="padding:10px;border:1px solid #cbd5e1;text-align:right;">Gross Income (in INR)</th>
                  <th style="padding:10px;border:1px solid #cbd5e1;">Gross Income (in Words)</th>
                </tr>
              </thead>
              <tbody>${rowsHtml}</tbody>
            </table>
            <p style="margin-top:18px;line-height:1.7;color:#0f172a;">This declared income is verified based on the Acknowledgements of Income Tax Returns filed by the client with the Income Tax Department.</p>
          </div>`;
      }
    }

    function previewCertificate() {
      if (!validateClientForm() || !validatePreviewForm()) {
        return;
      }
      const client = getClientDataFromForm();
      const type = getSelectedCertificateType();
      const dateValue = certificateDateInput.value || new Date().toISOString().slice(0,10);
      const place = placeInput.value.trim() || 'Ahmedabad';
      const udin = udinInput.value.trim();
      const yearsRows = getYearRows();
      const firm = firmSettings || loadFirmSettings();

      const html = `
        <html>
          <head>
            <title>Preview Certificate</title>
            <style>
              @page { margin: 1cm; }
              @media print { @page { margin: 1cm; } body { margin: 0; } }
              body{font-family:Arial,sans-serif;margin:30px;color:#111;}
              table{width:100%;border-collapse:collapse;margin-top:15px;font-size:0.9rem;}
              th,td{padding:10px;border:1px solid #cbd5e1;text-align:left;}
              .footer{margin-top:35px;display:flex;justify-content:space-between;font-size:0.85rem;color:#334155;line-height:1.6;}
            </style>
          </head>
          <body>
            ${renderCertificateHtml(type, client, firm, dateValue, place, udin, yearsRows)}
            <div class="footer">
              <div>
                <div><strong>Date:</strong> ${formatDateDisplay(dateValue)}</div>
                <div><strong>Place:</strong> ${place}</div>
                <div><strong>UDIN:</strong> <span style="font-family:monospace;">${udin || '-'}</span></div>
              </div>
              <div style="text-align:right;">
                <div>For <strong>${firm?.firmName || '[Your CA Firm]'}</strong></div>
                <div>Chartered Accountants</div><br><br>
                <div><strong>${firm?.signatoryName || '[Authorized Signatory]'}</strong></div>
                <div>${firm?.signatoryStatus || ''} ${firm?.membershipNumber ? '| M. No: ' + firm.membershipNumber : ''}</div>
              </div>
            </div>
          </body>
        </html>`;
      const printWindow = window.open('', '_blank');
      printWindow.document.write(html);
      printWindow.document.close();
      printWindow.focus();
      setTimeout(() => {
        printWindow.print();
      }, 500);
    }

    function downloadBackendPdf() {
      if (!validateClientForm() || !validatePreviewForm()) {
        return;
      }
      
      const client = getClientDataFromForm();
      const type = getSelectedCertificateType();
      const dateValue = certificateDateInput.value || new Date().toISOString().slice(0,10);
      const place = placeInput.value.trim() || 'Ahmedabad';
      const udin = udinInput.value.trim();
      const firm = firmSettings || loadFirmSettings();
      const style = templateStyleInput.value;

      document.getElementById('pdfClientData').value = JSON.stringify(client);
      document.getElementById('pdfFirmData').value = JSON.stringify(firm);
      document.getElementById('pdfCertType').value = type;
      document.getElementById('pdfCertDate').value = dateValue;
      document.getElementById('pdfPlace').value = place;
      document.getElementById('pdfUdin').value = udin;
      document.getElementById('pdfTemplateStyle').value = style;

      document.getElementById('pdfGenerationForm').submit();
    }

    window.editClient = editClient;
    window.selectClient = selectClient;
    window.deleteClient = deleteClient;

    addYearBtn.addEventListener('click', () => addYearRow());
    saveClientBtn.addEventListener('click', saveCurrentClient);
    clearFormBtn.addEventListener('click', resetClientForm);
    newClientBtn.addEventListener('click', resetClientForm);
    previewPrintBtn.addEventListener('click', previewCertificate);
    generatePdfBtn.addEventListener('click', downloadBackendPdf);

    setCurrentDate();
    loadFirmSettings();
    resetClientForm();
    renderClientsTable();
  </script>
</body>
</html>