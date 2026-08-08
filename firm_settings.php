<?php require_once 'auth_check.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Firm Settings - CA Certificate Manager</title>
  <!-- Custom Premium Styles -->
  <link rel="stylesheet" href="assets/css/style.css">
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
        <a class="nav-link-custom" href="index.php">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4 0 1 1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
          Clients & Generator
        </a>
        <a class="nav-link-custom active" href="firm_settings.php">
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
          <h1 class="page-title">CA Firm Settings</h1>
          <p class="page-subtitle">Configure signing authority details and default CA master information.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <div class="top-grid">
        <!-- Form Panel -->
        <div class="card-premium">
          <div class="card-header-premium">
            <h2 class="card-title-premium">
              <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="color: #2563eb;"><path d="M8 4.75a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0M8.5 7v3.5a.5.5 0 0 1-1 0V7.5a.5.5 0 0 1 .5-.5z"/><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/></svg>
              CA Firm Master Data
            </h2>
          </div>
          <div class="card-body-premium">
            <form id="firmForm" novalidate>
              <div class="form-grid">
                <div>
                  <label for="firmName" class="form-label-custom">CA Firm Name *</label>
                  <input id="firmName" type="text" class="form-control-custom" placeholder="Rudani & Associates">
                </div>
                <div>
                  <label for="frn" class="form-label-custom">Firm Registration Number (FRN) *</label>
                  <input id="frn" type="text" class="form-control-custom" placeholder="123456W">
                </div>
                <div>
                  <label for="signatoryName" class="form-label-custom">Name of Signatory *</label>
                  <input id="signatoryName" type="text" class="form-control-custom" placeholder="N B Rudani">
                </div>
                <div>
                  <label for="signatoryStatus" class="form-label-custom">Status of Signatory *</label>
                  <select id="signatoryStatus" class="form-control-custom">
                    <option value="Proprietor">Proprietor</option>
                    <option value="Partner">Partner</option>
                  </select>
                </div>
                <div>
                  <label for="membershipNumber" class="form-label-custom">Membership Number *</label>
                  <input id="membershipNumber" type="text" class="form-control-custom" placeholder="123456">
                </div>
                <div>
                  <label for="udin" class="form-label-custom">Default UDIN Number *</label>
                  <input id="udin" type="text" class="form-control-custom" placeholder="25123456BMJXY1234">
                </div>
              </div>

              <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="button" id="saveFirmBtn" class="btn-custom btn-custom-primary">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.594l1.646-1.647a.5.5 0 0 1 .708.708l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5a.5.5 0 1 1 .708-.708L7.5 6.594V2a1 1 0 0 0-1-1H2z"/></svg>
                  Save Settings
                </button>
                <button type="button" id="clearFirmBtn" class="btn-custom btn-custom-secondary">
                  <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                  Reset Settings
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Saved Info Panel -->
        <div class="card-premium">
          <div class="card-header-premium">
            <h2 class="card-title-premium">
              <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="color: #10b981;"><path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.243 4.243a.5.5 0 0 0-.707-.707l-3.5 3.5a.5.5 0 1 0 .707.707l3.5-3.5z"/></svg>
              Saved Firm Details
            </h2>
          </div>
          <div class="card-body-premium" style="padding:0;">
            <div id="firmDetails" style="padding: 20px;"></div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    const firmKey = 'ca_firm_settings';
    const pageDate = document.getElementById('pageDate');
    const firmName = document.getElementById('firmName');
    const frn = document.getElementById('frn');
    const signatoryName = document.getElementById('signatoryName');
    const signatoryStatus = document.getElementById('signatoryStatus');
    const membershipNumber = document.getElementById('membershipNumber');
    const udin = document.getElementById('udin');
    const firmDetails = document.getElementById('firmDetails');

    (function(){
      fetch('auth_session.php').then(r=>r.json()).then(data=>{
        if (data.user) {
          document.getElementById('sidebarUser').textContent = data.user.username;
          document.getElementById('sidebarRole').textContent = data.user.role;
          document.getElementById('sidebarAvatar').textContent = data.user.username.charAt(0).toUpperCase();
        }
      }).catch(()=>{});
    })();

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

    function validateFirmForm() {
      clearAllValidation();
      let valid = true;
      if (!firmName.value.trim()) {
        showValidationError($(firmName), 'Firm name is required.');
        valid = false;
      }
      if (!frn.value.trim()) {
        showValidationError($(frn), 'FRN is required.');
        valid = false;
      }
      if (!signatoryName.value.trim()) {
        showValidationError($(signatoryName), 'Signatory name is required.');
        valid = false;
      }
      if (!membershipNumber.value.trim()) {
        showValidationError($(membershipNumber), 'Membership number is required.');
        valid = false;
      }
      if (!udin.value.trim()) {
        showValidationError($(udin), 'UDIN number is required.');
        valid = false;
      }
      return valid;
    }

    $('input, select').on('input change', function() {
      clearValidation($(this));
    });

    function formatDateDisplay(value) {
      const date = new Date(value);
      return date.toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' });
    }

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + formatDateDisplay(today.toISOString().slice(0,10));
    }

    function loadFirm() {
      const saved = localStorage.getItem(firmKey);
      const firm = saved ? JSON.parse(saved) : null;
      if (firm) {
        firmName.value = firm.firmName || '';
        frn.value = firm.frn || '';
        signatoryName.value = firm.signatoryName || '';
        signatoryStatus.value = firm.signatoryStatus || 'Proprietor';
        membershipNumber.value = firm.membershipNumber || '';
        udin.value = firm.udin || '';
        renderFirm(firm);
      } else {
        firmDetails.innerHTML = '<div style="text-align:center; padding:40px; color:#64748b;"><p>No CA firm details stored yet.</p></div>';
      }
    }

    function renderFirm(firm) {
      firmDetails.innerHTML = `
        <div class="table-responsive-custom">
          <table class="table-custom">
            <tbody>
              <tr><th style="width: 40%; background:transparent; border-bottom:1px solid #f1f5f9; padding:12px;">Firm Name</th><td style="border-bottom:1px solid #f1f5f9; padding:12px; font-weight:700;">${firm.firmName}</td></tr>
              <tr><th style="background:transparent; border-bottom:1px solid #f1f5f9; padding:12px;">FRN</th><td style="border-bottom:1px solid #f1f5f9; padding:12px;">${firm.frn || '-'}</td></tr>
              <tr><th style="background:transparent; border-bottom:1px solid #f1f5f9; padding:12px;">Signatory</th><td style="border-bottom:1px solid #f1f5f9; padding:12px;">${firm.signatoryName} (${firm.signatoryStatus})</td></tr>
              <tr><th style="background:transparent; border-bottom:1px solid #f1f5f9; padding:12px;">Membership No</th><td style="border-bottom:1px solid #f1f5f9; padding:12px;">${firm.membershipNumber || '-'}</td></tr>
              <tr><th style="background:transparent; border-bottom:none; padding:12px;">Default UDIN</th><td style="border-bottom:none; padding:12px; font-family:monospace;">${firm.udin || '-'}</td></tr>
            </tbody>
          </table>
        </div>`;
    }

    document.getElementById('saveFirmBtn').addEventListener('click', () => {
      if (!validateFirmForm()) {
        return;
      }
      const firm = {
        firmName: firmName.value.trim(),
        frn: frn.value.trim(),
        signatoryName: signatoryName.value.trim(),
        signatoryStatus: signatoryStatus.value,
        membershipNumber: membershipNumber.value.trim(),
        udin: udin.value.trim()
      };
      localStorage.setItem(firmKey, JSON.stringify(firm));
      renderFirm(firm);
      alert('Firm settings saved successfully.');
    });

    document.getElementById('clearFirmBtn').addEventListener('click', () => {
      clearAllValidation();
      localStorage.removeItem(firmKey);
      firmName.value = '';
      frn.value = '';
      signatoryName.value = '';
      signatoryStatus.value = 'Proprietor';
      membershipNumber.value = '';
      udin.value = '';
      firmDetails.innerHTML = '<div style="text-align:center; padding:40px; color:#64748b;"><p>No CA firm details stored yet.</p></div>';
    });

    setCurrentDate();
    loadFirm();
  </script>
</body>
</html>