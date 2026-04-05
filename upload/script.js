const dropZone      = document.getElementById('drop-zone');
const fileInput     = document.getElementById('file-input');
const previewImg    = document.getElementById('preview-img');
const previewHolder = document.getElementById('preview-placeholder');
const btnUpload     = document.getElementById('btn-upload');
const btnReset      = document.getElementById('btn-reset');
const infoSection   = document.getElementById('info-section');
const alertError    = document.getElementById('alert-error');
const alertSuccess  = document.getElementById('alert-success');
const savedSection  = document.getElementById('saved-section');
const savedGrid     = document.getElementById('saved-grid');

let selectedFile = null;
let savedName    = '';

function processFilename(original) {
  const dot   = original.lastIndexOf('.');
  const base  = original.slice(0, dot);
  const ext   = original.slice(dot + 1);

  const lower = base.toLowerCase();
  const clean = lower
                  .replace(/\s+/g, '_')
                  .replace(/[^a-z0-9_]/g, '');

  const ts    = Date.now();
  const saved = `${ts}_${clean}.${ext.toLowerCase()}`;

  return { base, lower: lower + '.' + ext.toLowerCase(), ext: '.' + ext.toLowerCase(), saved };
}

function fmtSize(b) {
  if (b < 1024)    return b + ' B';
  if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
  return (b / 1048576).toFixed(2) + ' MB';
}

function isValid(file) {
  const n = file.name.toLowerCase();
  return n.endsWith('.jpg') || n.endsWith('.jpeg') || n.endsWith('.png');
}

function handleFile(file) {
  hide(alertError); hide(alertSuccess);

  if (!isValid(file)) {
    show(alertError, `"${file.name}" only .jpg, .jpeg, and .png are allowed.`);
    return;
  }

  selectedFile = file;

  const reader = new FileReader();
  reader.onload = e => {
    previewImg.src = e.target.result;
    previewImg.style.display = 'block';
    previewHolder.style.display = 'none';
  };
  reader.readAsDataURL(file);

  const info = processFilename(file.name);
  savedName  = info.saved;

  document.getElementById('td-original').textContent = file.name;
  document.getElementById('td-lower').textContent    = info.lower;
  document.getElementById('td-base').textContent     = info.base;
  document.getElementById('td-ext').textContent      = info.ext;
  document.getElementById('td-saved').textContent    = info.saved;
  document.getElementById('td-size').textContent     = fmtSize(file.size);
  document.getElementById('td-type').textContent     = file.type || 'image/' + info.ext.slice(1);

  infoSection.style.display = 'flex';
  infoSection.style.flexDirection = 'column';
  btnUpload.disabled = false;
  btnReset.disabled  = false;
}

function clearSelection() {
  selectedFile = null;
  savedName    = '';
  fileInput.value = '';
  previewImg.src  = '';
  previewImg.style.display  = 'none';
  previewHolder.style.display = 'block';
  infoSection.style.display   = 'none';
  btnUpload.disabled = true;
  btnReset.disabled  = true;
}

dropZone.addEventListener('click',     () => fileInput.click());
dropZone.addEventListener('dragover',  e  => { e.preventDefault(); dropZone.classList.add('dragover'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
dropZone.addEventListener('drop', e => {
  e.preventDefault();
  dropZone.classList.remove('dragover');
  if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
});
fileInput.addEventListener('change', () => {
  if (fileInput.files[0]) handleFile(fileInput.files[0]);
});

btnReset.addEventListener('click', () => {
  clearSelection();
  hide(alertError);
  hide(alertSuccess);
});

btnUpload.addEventListener('click', async () => {
  if (!selectedFile) return;
  hide(alertError); hide(alertSuccess);

  if (!window.showSaveFilePicker) {
    fallbackDownload(selectedFile, savedName);
    return;
  }

  try {
    const ext     = savedName.split('.').pop();
    const mimeMap = { jpg: 'image/jpeg', jpeg: 'image/jpeg', png: 'image/png' };
    const mime    = mimeMap[ext] || 'image/*';

    const fileHandle = await window.showSaveFilePicker({
      suggestedName: savedName,
      types: [{
        description: 'Image',
        accept: { [mime]: ['.' + ext] }
      }]
    });

    const writable = await fileHandle.createWritable();
    await writable.write(selectedFile);
    await writable.close();

    const realName = fileHandle.name;
    show(alertSuccess, `Photo saved successfully as "${realName}".`);
    addSavedCard(previewImg.src, realName);
    clearSelection();

  } catch (err) {
    if (err.name !== 'AbortError') {
      show(alertError, 'Failed to save file: ' + err.message);
    }
  }
});

function fallbackDownload(file, name) {
  const url = URL.createObjectURL(file);
  const a   = document.createElement('a');
  a.href     = url;
  a.download = name;
  a.click();
  URL.revokeObjectURL(url);
  show(alertSuccess, `Photo downloaded as "${name}" to Downloads folder.`);
  addSavedCard(previewImg.src, name);
  clearSelection();
}

function addSavedCard(src, name) {
  savedSection.style.display = 'flex';
  savedSection.style.flexDirection = 'column';
  const card = document.createElement('div');
  card.className = 'saved-card';
  card.innerHTML = `
    <div class="card-picture">
      <img src="${src}" alt="${name}" />
    </div>
    <p class="card-name saved-name">${name}</p>
  `;
  savedGrid.prepend(card);
}

function show(el, msg) { el.textContent = msg; el.style.display = 'block'; }
function hide(el)      { el.style.display = 'none'; el.textContent = ''; }
