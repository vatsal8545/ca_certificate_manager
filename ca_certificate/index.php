<?php require_once 'auth_check.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Certificate Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
  <div class="page-shell">
    <aside class="sidebar">
      <div class="brand">CA Certificate Manager</div>
      <p class="brand-subtitle">Simple • Fast • Accurate</p>
      <nav>
        <a class="active" href="index.php">Clients & Generator</a>
        <a href="firm_settings.php">Firm Settings</a>
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
          <h1>Client & Certificate Generator</h1>
          <p>Manage your clients and generate certified financial documents.</p>
        </div>
        <div class="page-date" id="pageDate">Date: --</div>
      </div>
      <div class="top-grid">
        <section class="panel card">
          <div class="panel-header">
            <h2>Edit Client Details</h2>
            <button class="secondary" id="newClientBtn">New Client</button>
          </div>
          <div class="form-grid">
            <label>Name of Client *<input id="clientNameInput" type="text" placeholder="Enter client name"></label>
            <label>Status of Client *<select id="clientStatusInput"><option>Proprietor</option><option>Firm</option><option>Company</option></select></label>
            <label>PAN Number *<input id="panInput" type="text" placeholder="PAN"></label>
            <label>GST Number (if applicable)<input id="gstInput" type="text" placeholder="GST"></label>
          </div>
          <div class="section-title">
            <span>Financial Years & Amounts</span>
            <button class="secondary small" id="addYearBtn">+ Add Year</button>
          </div>
          <div id="yearsContainer" class="years-grid"></div>
          <div class="summary-bar">
            <div>Average Annual Value:</div>
            <div class="summary-value" id="avgAnnualValue">₹0</div>
          </div>
          <div class="form-actions">
            <button id="saveClientBtn">Save Client Details</button>
            <button id="clearFormBtn" class="secondary">Clear Form</button>
          </div>
        </section>

        <section class="panel card side-panel">
          <div class="section-title"><span>Select Certificate Type</span></div>
          <div class="option-list">
            <label class="option active"><input type="radio" name="certType" value="Turnover Certificate" checked><span>Turnover Certificate</span></label>
            <label class="option"><input type="radio" name="certType" value="Net Worth Certificate"><span>Net Worth Certificate</span></label>
            <label class="option"><input type="radio" name="certType" value="Working Capital Certificate"><span>Working Capital Certificate</span></label>
            <label class="option"><input type="radio" name="certType" value="Existence Certificate"><span>Existence Certificate</span></label>
          </div>

          <div class="section-title"><span>Generate Details</span></div>
          <div class="form-grid">
            <label>Date of Certificate *<input id="certificateDateInput" type="date"></label>
            <label>Place of Signing *<input id="placeInput" type="text" placeholder="Ahmedabad"></label>
            <label>UDIN Number *<input id="udinInput" type="text" placeholder="UDIN"></label>
          </div>
          <button id="previewPrintBtn" class="primary">Preview & Print PDF</button>
        </section>
      </div>

      <section class="panel card table-panel">
        <div class="panel-header">
          <h2>Registered Clients Database</h2>
        </div>
        <div class="table-scroll">
          <table>
            <thead>
              <tr><th>Name of Client</th><th>Status</th><th>PAN Number</th><th>GST Number</th><th>Financial Years Checked</th><th>Actions</th></tr>
            </thead>
            <tbody id="clientsTableBody"></tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <script>
    // Show logged-in user info if available via session check endpoint (optional)
    (function(){
      // Try to fetch session user via a lightweight PHP endpoint if present
      fetch('auth_session.php').then(r=>r.json()).then(data=>{
        if (data.user) {
          document.getElementById('sidebarUser').textContent = data.user.username;
          document.getElementById('sidebarRole').textContent = data.user.role;
        }
      }).catch(()=>{});
    })();
    const clientsKey = 'ca_clients';
    const firmKey = 'ca_firm_settings';
    let editingId = null;
    let firmSettings = null;

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
    const clientsTableBody = document.getElementById('clientsTableBody');

    const saveClientBtn = document.getElementById('saveClientBtn');
    const clearFormBtn = document.getElementById('clearFormBtn');
    const addYearBtn = document.getElementById('addYearBtn');
    const newClientBtn = document.getElementById('newClientBtn');
    const previewPrintBtn = document.getElementById('previewPrintBtn');

    const certTypeRadios = document.querySelectorAll('[name="certType"]');

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
      const rows = [...yearsContainer.querySelectorAll('.year-row')];
      if (!rows.length) {
        $('<div class="validation-message">Add at least one financial year and amount.</div>').insertAfter($(yearsContainer));
        valid = false;
      }
      rows.forEach(row => {
        const $year = $(row).find('.year-field');
        const $amount = $(row).find('.amount-field');
        if (!$year.val().trim()) {
          showValidationError($year, 'Year is required.');
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
      return parsed;
    }

    function setCurrentDate() {
      const today = new Date();
      pageDate.textContent = 'Date: ' + formatDateDisplay(today.toISOString().slice(0,10));
      certificateDateInput.value = today.toISOString().slice(0,10);
    }

    function loadClients() {
      return JSON.parse(localStorage.getItem(clientsKey) || '[]');
    }

    function saveClients(clients) {
      localStorage.setItem(clientsKey, JSON.stringify(clients));
      renderClientsTable();
    }

    function createYearRow(year = '', amount = '') {
      const row = document.createElement('div');
      row.className = 'year-row';
      row.innerHTML = `
        <input type="text" class="year-field" placeholder="2023-24" value="${year}">
        <input type="number" class="amount-field" placeholder="Amount" value="${amount}">
        <button type="button" class="year-remove">×</button>
      `;
      row.querySelector('.year-remove').addEventListener('click', () => {
        row.remove();
        updateSummary();
      });
      row.querySelector('.year-field').addEventListener('input', updateSummary);
      row.querySelector('.amount-field').addEventListener('input', updateSummary);
      return row;
    }

    function updateSummary() {
      const rows = [...yearsContainer.querySelectorAll('.year-row')];
      const amounts = rows
        .map(row => Number(row.querySelector('.amount-field').value) || 0)
        .filter(value => value > 0);
      if (!amounts.length) {
        avgAnnualValue.textContent = '₹0';
        return;
      }
      const average = Math.round(amounts.reduce((sum, value) => sum + value, 0) / amounts.length);
      avgAnnualValue.textContent = '₹' + average.toLocaleString('en-IN');
    }

    function addYearRow(year = '', amount = '') {
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
      addYearRow();
      updateSummary();
    }

    function getSelectedCertificateType() {
      return [...certTypeRadios].find(radio => radio.checked).value;
    }

    function getClientDataFromForm() {
      return {
        id: editingId || Date.now().toString(),
        name: clientNameInput.value.trim(),
        status: clientStatusInput.value,
        pan: panInput.value.trim(),
        gst: gstInput.value.trim(),
        years: [...yearsContainer.querySelectorAll('.year-row')].map(row => ({
          year: row.querySelector('.year-field').value.trim(),
          amount: row.querySelector('.amount-field').value.trim()
        })).filter(row => row.year && row.amount)
      };
    }

    function validateClientData(client) {
      return client.name && client.status && client.pan && client.years.length > 0;
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
        clientsTableBody.innerHTML = '<tr><td colspan="6" class="empty">No clients registered yet.</td></tr>';
        return;
      }
      clientsTableBody.innerHTML = clients.map(client => {
        const years = client.years.map(item => item.year).join(', ');
        return `
          <tr>
            <td>${client.name}</td>
            <td>${client.status}</td>
            <td>${client.pan}</td>
            <td>${client.gst || '-'}</td>
            <td>${years}</td>
            <td class="actions">
              <button class="small secondary" onclick="editClient('${client.id}')">Edit</button>
              <button class="small primary" onclick="selectClient('${client.id}')">Select</button>
              <button class="small danger" onclick="deleteClient('${client.id}')">Delete</button>
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
      client.years.forEach(year => addYearRow(year.year, year.amount));
      updateSummary();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function selectClient(id) {
      editClient(id);
    }

    function deleteClient(id) {
      const clients = loadClients().filter(item => item.id !== id);
      saveClients(clients);
    }

    function getYearRows() {
      return [...yearsContainer.querySelectorAll('.year-row')].map(row => ({
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
      return words + ' Only';
    }

    function renderCertificateHtml(type, client, firm, dateValue, place, udin, yearsRows) {
      const header = `
        <div style="text-align:center;margin-bottom:24px;">
          <div style="font-size:0.95rem;letter-spacing:0.2em;color:#0f172a;">TO WHOMSOEVER IT MAY CONCERN</div>
          <h1 style="margin:14px 0 6px;font-size:1.8rem;color:#102a43;">${type.toUpperCase()}</h1>
        </div>`;

      const firmNameText = firm?.firmName || '[Name of your CA Firm]';
      const firmFrnText = firm?.frn || '[FRN Number]';
      const firmSignatory = firm?.signatoryName || '[Your Name]';
      const firmSignatoryStatus = firm?.signatoryStatus || 'Proprietor';
      const firmMembership = firm?.membershipNumber || '[Membership No]';
      const firmUdinText = firm?.udin || udin || '[UDIN]';

      const firmHeader = `
        <div style="text-align:center;margin-bottom:18px;">
          <div style="font-size:1.05rem;font-weight:700;color:#102a43;">${firmNameText}</div>
          <div style="font-size:0.95rem;color:#475569;">Chartered Accountants</div>
          <div style="font-size:0.9rem;color:#475569;margin-top:4px;">FRN ${firmFrnText}</div>
        </div>`;

      const basicIntro = `
        <p style="line-height:1.7;color:#2d3748;">We, <strong>${client.name}</strong> (${client.status}), having its registered office/principal place of business at <strong>[Full Address of the Entity]</strong> and holding PAN <strong>${client.pan}</strong>${client.gst ? ` and GSTIN <strong>${client.gst}</strong>` : ''}, have examined the books of accounts and financial statements and certify the details below.</p>`;

      if (type === 'Turnover Certificate') {
        const rowsHtml = yearsRows.map(row => `
            <tr>
              <td>${row.year}</td>
              <td>₹${Number(row.amount).toLocaleString('en-IN')}</td>
              <td>Rupees ${amountInWords(row.amount)}</td>
            </tr>`).join('');
        const average = yearsRows.reduce((sum, row) => sum + (Number(row.amount) || 0), 0) / (yearsRows.length || 1);
        return `
          ${firmHeader}
          ${header}
          ${basicIntro}
          <p style="line-height:1.7;color:#2d3748;">The figures stated below have been verified by us based on the audited financial statements, books of accounts and other relevant records produced before us for the respective periods.</p>
          <table style="width:100%;border-collapse:collapse;margin-top:20px;">
            <thead>
              <tr style="background:#0f172a;color:#fff;text-align:left;"><th style="padding:12px;border:1px solid #d1d5db;">Financial Year</th><th style="padding:12px;border:1px solid #d1d5db;">Turnover (in INR)</th><th style="padding:12px;border:1px solid #d1d5db;">Turnover (in Words)</th></tr>
            </thead>
            <tbody>${rowsHtml}</tbody>
          </table>
          <p style="margin-top:20px;line-height:1.7;color:#2d3748;"><strong>Average Annual Turnover:</strong> The average annual turnover of the entity for the above-mentioned financial years is INR <strong>₹${Math.round(average).toLocaleString('en-IN')}</strong> (Rupees <strong>${amountInWords(Math.round(average))}</strong>).</p>
          <p style="margin-top:18px;font-size:0.95rem;color:#475569;">Notes & Disclaimers:<br><small>The figures are based on the books of accounts presented to us and are subject to audit.</small></p>`;
      }

      if (type === 'Net Worth Certificate') {
        const paidUp = Number(yearsRows[0]?.amount || 0);
        const reserves = Number(yearsRows[1]?.amount || 0);
        const netWorth = paidUp + reserves;
        return `
          ${firmHeader}
          ${header}
          ${basicIntro}
          <p style="line-height:1.7;color:#2d3748;">Based on the Balance Sheet as on <strong>${formatDateDisplay(dateValue)}</strong>, the net worth of the above entity is as under:</p>
          <table style="width:100%;border-collapse:collapse;margin-top:20px;">
            <thead>
              <tr style="background:#0f172a;color:#fff;text-align:left;"><th style="padding:12px;border:1px solid #d1d5db;">Particulars</th><th style="padding:12px;border:1px solid #d1d5db;">Amount (₹)</th></tr>
            </thead>
            <tbody>
              <tr><td style="padding:12px;border:1px solid #d1d5db;">(A) Paid-up Share Capital / Capital</td><td style="padding:12px;border:1px solid #d1d5db;">₹${paidUp.toLocaleString('en-IN')} (${amountInWords(paidUp)})</td></tr>
              <tr><td style="padding:12px;border:1px solid #d1d5db;">(B) Reserves & Surplus</td><td style="padding:12px;border:1px solid #d1d5db;">₹${reserves.toLocaleString('en-IN')} (${amountInWords(reserves)})</td></tr>
              <tr style="background:#f8fafc;"><td style="padding:12px;border:1px solid #d1d5db;"><strong>Net Worth (A + B)</strong></td><td style="padding:12px;border:1px solid #d1d5db;"><strong>₹${netWorth.toLocaleString('en-IN')}</strong> (${amountInWords(netWorth)})</strong></td></tr>
            </tbody>
          </table>
          <p style="margin-top:18px;line-height:1.7;color:#2d3748;">The net worth of the entity as on the above date is ₹${netWorth.toLocaleString('en-IN')} (${amountInWords(netWorth)}).</p>`;
      }

      if (type === 'Working Capital Certificate') {
        const currentAssets = Number(yearsRows[0]?.amount || 0);
        const currentLiabilities = Number(yearsRows[1]?.amount || 0);
        const workingCapital = currentAssets - currentLiabilities;
        return `
          ${firmHeader}
          ${header}
          ${basicIntro}
          <p style="line-height:1.7;color:#2d3748;">Based on the Balance Sheet as on <strong>${formatDateDisplay(dateValue)}</strong>, the working capital position of the above entity is as under:</p>
          <table style="width:100%;border-collapse:collapse;margin-top:20px;">
            <thead>
              <tr style="background:#0f172a;color:#fff;text-align:left;"><th style="padding:12px;border:1px solid #d1d5db;">Particulars</th><th style="padding:12px;border:1px solid #d1d5db;">Amount (₹)</th></tr>
            </thead>
            <tbody>
              <tr><td style="padding:12px;border:1px solid #d1d5db;">(A) Current Assets</td><td style="padding:12px;border:1px solid #d1d5db;">₹${currentAssets.toLocaleString('en-IN')}</td></tr>
              <tr><td style="padding:12px;border:1px solid #d1d5db;">(B) Current Liabilities</td><td style="padding:12px;border:1px solid #d1d5db;">₹${currentLiabilities.toLocaleString('en-IN')}</td></tr>
              <tr style="background:#f8fafc;"><td style="padding:12px;border:1px solid #d1d5db;"><strong>Working Capital (A - B)</strong></td><td style="padding:12px;border:1px solid #d1d5db;"><strong>₹${workingCapital.toLocaleString('en-IN')}</strong></td></tr>
            </tbody>
          </table>
          <p style="margin-top:18px;line-height:1.7;color:#2d3748;">The working capital of the entity as on the above date is ₹${workingCapital.toLocaleString('en-IN')} (${amountInWords(workingCapital)}).</p>`;
      }

      return `
        ${firmHeader}
        ${header}
        ${basicIntro}
        <p style="line-height:1.7;color:#2d3748;">This is to certify that the above entity continues to exist and is operational as on <strong>${formatDateDisplay(dateValue)}</strong>.</p>`;
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
            <title></title>
            <style>
              /* reduce browser-added headers/footers where possible */
              @page { margin: 0.6cm; }
              @media print { @page { margin: 0.6cm; } body { margin: 0; } }
              body{font-family:Arial,sans-serif;margin:40px;color:#111;}
              h1{margin:8px 0 12px;font-size:1.8rem;color:#102a43;}
              p{line-height:1.7;color:#2d3748;}
              table{width:100%;border-collapse:collapse;margin-top:18px;font-size:0.95rem;}
              th,td{padding:12px;border:1px solid #d1d5db;text-align:left;}
              th{background:#0f172a;color:#fff;}
              .footer{margin-top:32px;display:flex;justify-content:space-between;font-size:0.95rem;color:#475569;}
            </style>
          </head>
          <body>
            ${renderCertificateHtml(type, client, firm, dateValue, place, udin, yearsRows)}
            <div class="footer">
              <div>
                <div>Date: ${formatDateDisplay(dateValue)}</div>
                <div>Place: ${place}</div>
                <div>UDIN: ${udin || '-'}</div>
              </div>
              <div style="text-align:right;">
                <div>For ${firm?.firmName || client.name}</div>
                <div style="margin-top:40px;">${firm?.signatoryName || 'Authorised Signatory'}</div>
                <div>${firm?.signatoryStatus || ''}${firm?.membershipNumber ? ' | M. No: ' + firm.membershipNumber : ''}</div>
              </div>
            </div>
          </body>
        </html>`;
      const printWindow = window.open('', '_blank');
      printWindow.document.write(html);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
    }

    window.editClient = editClient;
    window.selectClient = selectClient;
    window.deleteClient = deleteClient;

    addYearBtn.addEventListener('click', () => addYearRow());
    saveClientBtn.addEventListener('click', saveCurrentClient);
    clearFormBtn.addEventListener('click', resetClientForm);
    newClientBtn.addEventListener('click', resetClientForm);
    previewPrintBtn.addEventListener('click', previewCertificate);

    setCurrentDate();
    resetClientForm();
    renderClientsTable();
  </script>
</body>
</html>