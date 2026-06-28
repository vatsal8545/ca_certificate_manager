<?php require_once 'auth_check.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Firm Settings - CA Certificate Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
  <div class="page-shell">
    <aside class="sidebar">
      <div class="brand">CA Certificate Manager</div>
      <p class="brand-subtitle">Simple • Fast • Accurate</p>
      <nav>
        <a href="index.php">Clients & Generator</a>
        <a class="active" href="firm_settings.php">Firm Settings</a>
        <a href="profile.php">Profile</a>
      </nav>
      <div class="sidebar-footer">
        <div class="avatar">A</div>
        <div>
          <strong id="sidebarUser">admin</strong>
          <span id="sidebarRole">Administrator</span>
        </div>
        <div style="margin-left:12px"><a href="logout.php">Logout</a></div>
      </div>
    </aside>
    <main class="main-content">
      <div class="page-header">
        <div>
          <h1>CA Firm Settings</h1>
          <p>Configure signing authority details and default CA master information.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>

      <section class="panel card">
        <div class="panel-header">
          <h2>Configure CA Firm Master Data</h2>
        </div>
        <div class="form-grid firm-grid">
          <label>CA Firm Name *<input id="firmName" type="text" placeholder="Rudani & Associates"></label>
          <label>Firm Registration Number (FRN) *<input id="frn" type="text" placeholder="123456W"></label>
          <label>Name of Signatory *<input id="signatoryName" type="text" placeholder="N B Rudani"></label>
          <label>Status of Signatory *<select id="signatoryStatus"><option>Proprietor</option><option>Partner</option></select></label>
          <label>Membership Number *<input id="membershipNumber" type="text" placeholder="123456"></label>
          <label>Default UDIN Number *<input id="udin" type="text" placeholder="25123456BMJXY1234"></label>
        </div>
        <div class="form-actions">
          <button id="saveFirmBtn">Update Firm Settings</button>
          <button id="clearFirmBtn" class="secondary">Clear Form</button>
        </div>
      </section>
      <section class="panel card">
        <h2>Saved Firm Data</h2>
        <div id="firmDetails"></div>
      </section>
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

    function clearValidation($el) {
      $el.removeClass('input-error');
      $el.next('.validation-message').remove();
    }

    function clearAllValidation() {
      $('.input-error').removeClass('input-error');
      $('.validation-message').remove();
    }

    function showValidationError($el, message) {
      clearValidation($el);
      $el.addClass('input-error');
      $('<div class="validation-message"></div>').text(message).insertAfter($el);
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
        firmDetails.innerHTML = '<p class="empty">No firm settings saved yet.</p>';
      }
    }

    function renderFirm(firm) {
      firmDetails.innerHTML = `
        <table>
          <tbody>
            <tr><th>CA Firm Name</th><td>${firm.firmName}</td></tr>
            <tr><th>FRN</th><td>${firm.frn || '-'}</td></tr>
            <tr><th>Signatory</th><td>${firm.signatoryName} (${firm.signatoryStatus})</td></tr>
            <tr><th>Membership No</th><td>${firm.membershipNumber || '-'}</td></tr>
            <tr><th>UDIN</th><td>${firm.udin || '-'}</td></tr>
          </tbody>
        </table>`;
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
      firmDetails.innerHTML = '<p class="empty">No firm settings saved yet.</p>';
    });

    setCurrentDate();
    loadFirm();
  </script>
</body>
</html>