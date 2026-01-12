<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RAGBot</title>

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,sans-serif;background:#0a0a0f;color:#e5e5ea;min-height:100vh;display:flex;flex-direction:column}

.header{background:#141419;padding:1rem;border-bottom:1px solid #2a2a35}
.header-content{max-width:1400px;margin:auto;display:flex;justify-content:space-between;align-items:center}
.header h1{font-size:1.1rem}
.header-actions{display:flex;gap:0.5rem;align-items:center}
.header-btn{background:#6366f1;color:white;padding:0.5rem 1rem;border-radius:6px;font-size:0.85rem;border:none;cursor:pointer}
.header-btn:hover{opacity:0.8}
.header-btn.danger{background:#ef4444}

.container{flex:1;display:flex;gap:1rem}

/* SIDEBAR ICON MENU */
.icon-sidebar{background:#141419;border-right:1px solid #2a2a35;width:70px;display:flex;flex-direction:column;align-items:center;padding:1rem 0;gap:1rem}
.icon-btn{width:50px;height:50px;border:2px solid #2a2a35;background:#1e1e28;color:#e5e5ea;border-radius:12px;font-size:1.8rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s;position:relative}
.icon-btn:hover{background:#252531;border-color:#6366f1}
.icon-btn.active{background:#6366f1;border-color:#6366f1;color:white}
.icon-btn::after{content:'';position:absolute;left:-8px;width:4px;height:20px;background:#6366f1;border-radius:2px;opacity:0;transition:opacity 0.3s}
.icon-btn.active::after{opacity:1}

/* MAIN CONTENT AREA */
.main-content{flex:1;max-width:1400px;width:100%;padding:1rem;display:grid;grid-template-columns:300px 1fr;gap:1rem}

/* CONVERSATIONS SIDEBAR */
.conversations-sidebar{background:#141419;border-radius:10px;padding:1rem;border:1px solid #2a2a35;max-height:calc(100vh - 160px);display:flex;flex-direction:column;opacity:1;transition:all 0.3s;visibility:visible}
.conversations-sidebar.hidden{display:none}
.conversations-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:0.5rem;border-bottom:1px solid #2a2a35}
.conversations-header h3{font-size:0.95rem}
.new-chat-btn{background:#10b981;color:white;border:none;padding:0.4rem 0.8rem;border-radius:6px;font-size:0.85rem;cursor:pointer}
.new-chat-btn:hover{opacity:0.8}

.conversations-list{flex:1;overflow-y:auto}
.conversation-item{background:#1e1e28;padding:0.75rem;border-radius:8px;margin-bottom:0.5rem;cursor:pointer;transition:all 0.2s;position:relative}
.conversation-item:hover{background:#252531}
.conversation-item.active{background:#6366f1;color:white}
.conversation-title{font-size:0.9rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.conversation-meta{font-size:0.75rem;color:#888;margin-top:0.2rem}
.conversation-item.active .conversation-meta{color:#ddd}
.delete-conv-btn{position:absolute;top:0.5rem;right:0.5rem;background:#ef4444;border:none;color:white;padding:0.2rem 0.4rem;border-radius:4px;font-size:0.7rem;cursor:pointer;opacity:0}
.conversation-item:hover .delete-conv-btn{opacity:1}

/* DOCUMENTS SIDEBAR */
.docs-sidebar{background:#141419;border-radius:10px;padding:1rem;border:1px solid #2a2a35;max-height:calc(100vh - 160px);display:flex;flex-direction:column;opacity:1;transition:all 0.3s;visibility:visible}
.docs-sidebar.hidden{display:none}
.docs-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:0.5rem;border-bottom:1px solid #2a2a35}
.docs-header h3{font-size:0.95rem}
.refresh-icon{background:none;border:none;color:#6366f1;cursor:pointer;font-size:1.1rem;padding:0.3rem}
.refresh-icon:hover{opacity:0.7}

.docs-list{flex:1;overflow-y:auto;margin-bottom:1rem}
.doc-item{background:#1e1e28;padding:0.75rem;border-radius:8px;margin-bottom:0.5rem;display:flex;justify-content:space-between;align-items:center;gap:0.5rem;transition:background 0.2s}
.doc-item:hover{background:#252531}
.doc-info{flex:1;overflow:hidden}
.doc-name{font-size:0.85rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:0.2rem}
.doc-id{font-size:0.7rem;color:#666}
.delete-btn{background:#ef4444;color:white;border:none;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.75rem;cursor:pointer;white-space:nowrap}
.delete-btn:hover{background:#dc2626}

.upload-zone{border:2px dashed #6366f1;padding:1rem;text-align:center;border-radius:8px;cursor:pointer;transition:all 0.2s;font-size:0.85rem}
.upload-zone:hover{background:rgba(99,102,241,.1);border-color:#818cf8}
.upload-zone.hover{background:rgba(99,102,241,.2);border-color:#818cf8}

/* CHAT AREA */
.chat-area{display:flex;flex-direction:column;background:#141419;border-radius:10px;border:1px solid #2a2a35;overflow:hidden;grid-column:2}
.chat-container{flex:1;overflow-y:auto;display:flex;flex-direction:column;gap:1rem;padding:1rem;min-height:calc(100vh - 220px);max-height:calc(100vh - 220px)}

.message{display:flex;gap:.5rem;animation:fadeIn 0.3s}
.message.user{justify-content:flex-end}
.message-content{background:#1e1e28;padding:.75rem 1rem;border-radius:10px;max-width:75%;word-wrap:break-word;line-height:1.5;position:relative}
.message.user .message-content{background:#6366f1}

/* 🆕 Badge source */
.source-badge{
  display:inline-block;
  font-size:0.7rem;
  padding:0.2rem 0.5rem;
  margin-top:0.5rem;
  border-radius:4px;
  background:rgba(99,102,241,0.2);
  color:#818cf8;
  border:1px solid #6366f1;
}
.source-badge.web{background:rgba(16,185,129,0.2);color:#10b981;border-color:#10b981}
.source-badge.local{background:rgba(99,102,241,0.2);color:#818cf8;border-color:#6366f1}

.footer{padding:1rem;border-top:1px solid #2a2a35}
.input-form{display:flex;gap:.5rem}
input{flex:1;padding:.75rem;border-radius:8px;border:1px solid #2a2a35;background:#1e1e28;color:#fff}
button{border:none;border-radius:8px;cursor:pointer;transition:opacity 0.2s}
button:hover{opacity:0.8}

.send-btn{background:#6366f1;color:white;padding:.75rem 1rem}

.empty{text-align:center;padding:2rem 1rem;color:#666;font-size:0.9rem}
.loading{text-align:center;padding:2rem 1rem;color:#888}

@keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

@media (max-width: 1200px) {
  .container{flex-direction:column}
  .main-content{grid-template-columns:1fr;grid-template-rows:auto 1fr}
  .conversations-sidebar,.docs-sidebar{max-height:250px}
  .chat-area{grid-column:1}
  .chat-container{min-height:400px;max-height:400px}
}
</style>
</head>

<body>

<header class="header">
  <div class="header-content">
    <h1>🤖 RAGBot</h1>
    <div class="header-actions">
      <span id="webStatus" style="color:#10b981;font-size:0.85rem;display:none">🌐 Recherche web active</span>
      <span style="color:#10b981">● En ligne</span>
    </div>
  </div>
</header>

<div class="container">
  <!-- ICON SIDEBAR -->
  <aside class="icon-sidebar">
    <button class="icon-btn active" id="convBtn" onclick="togglePanel('conversations')" title="Conversations">
      💬
    </button>
    <button class="icon-btn" id="docsBtn" onclick="togglePanel('documents')" title="Documents">
      📚
    </button>
  </aside>

  <main class="main-content">
    <!-- CONVERSATIONS SIDEBAR -->
    <aside class="conversations-sidebar" id="conversationsSidebar">
      <div class="conversations-header">
        <h3>💬 Conversations</h3>
        <button class="new-chat-btn" onclick="createNewConversation()">+</button>
      </div>

      <div class="conversations-list" id="conversationsList">
        <div class="loading">⏳ Chargement...</div>
      </div>
    </aside>

    <!-- DOCUMENTS SIDEBAR -->
    <aside class="docs-sidebar hidden" id="docsSidebar">
      <div class="docs-header">
        <h3>📚 Documents</h3>
        <button class="refresh-icon" onclick="loadDocuments()" title="Rafraîchir">↻</button>
      </div>

      <div class="docs-list" id="docsList">
        <div class="loading">⏳ Chargement...</div>
      </div>

      <div class="upload-zone" id="uploadZone">
        📤 Glisser un fichier<br>
        <small style="color:#888">ou cliquer</small>
        <input type="file" id="fileInput" hidden>
      </div>
    </aside>

    <!-- CHAT AREA -->
    <div class="chat-area">
      <div class="chat-container" id="chat">
        <div class="message">
          <div class="message-content">👋 Bienvenue ! Créez une nouvelle conversation ou sélectionnez-en une.</div>
        </div>
      </div>

      <footer class="footer">
        <form class="input-form" onsubmit="event.preventDefault();sendMessage();">
          <input id="question" placeholder="Posez votre question..." autocomplete="off">
          <button class="send-btn" type="submit">➤</button>
        </form>
      </footer>
    </div>
  </main>
</div>

<script>
const API = window.API_URL || "http://localhost:8000";
let currentConversationId = null;

function togglePanel(panel) {
  const convSidebar = document.getElementById('conversationsSidebar');
  const docsSidebar = document.getElementById('docsSidebar');
  const convBtn = document.getElementById('convBtn');
  const docsBtn = document.getElementById('docsBtn');

  if (panel === 'conversations') {
    convSidebar.classList.remove('hidden');
    docsSidebar.classList.add('hidden');
    convBtn.classList.add('active');
    docsBtn.classList.remove('active');
  } else if (panel === 'documents') {
    docsSidebar.classList.remove('hidden');
    convSidebar.classList.add('hidden');
    docsBtn.classList.add('active');
    convBtn.classList.remove('active');
  }
}

window.addEventListener('DOMContentLoaded', () => {
  loadConversations();
  loadDocuments();
});

async function loadConversations(){
  const box = document.getElementById('conversationsList');
  box.innerHTML = '<div class="loading">⏳ Chargement...</div>';
  
  try{
    const r = await fetch(API + '/conversations');
    if(!r.ok) throw new Error('Erreur');
    
    const data = await r.json();
    const convs = data.conversations;
    
    box.innerHTML = '';
    
    if(convs.length === 0){
      box.innerHTML = '<div class="empty">Aucune conversation</div>';
      return;
    }
    
    convs.forEach(conv => {
      const item = document.createElement('div');
      item.className = 'conversation-item';
      if(conv.id === currentConversationId) item.classList.add('active');
      
      const date = new Date(conv.updated_at).toLocaleDateString('fr-FR');
      
      item.innerHTML = `
        <div class="conversation-title">${escapeHtml(conv.title)}</div>
        <div class="conversation-meta">${conv.message_count} messages · ${date}</div>
        <button class="delete-conv-btn" onclick="deleteConversation('${conv.id}', event)">✕</button>
      `;
      
      item.onclick = () => switchConversation(conv.id);
      box.appendChild(item);
    });
    
  } catch(e){
    box.innerHTML = '<div class="empty">❌ Erreur</div>';
    console.error(e);
  }
}

async function createNewConversation(){
  try{
    const r = await fetch(API + '/conversations/new', {method: 'POST'});
    if(!r.ok) throw new Error('Erreur');
    
    const data = await r.json();
    currentConversationId = data.id;
    
    document.getElementById('chat').innerHTML = `
      <div class="message">
        <div class="message-content">✨ Nouvelle conversation créée !</div>
      </div>
    `;
    
    loadConversations();
  } catch(e){
    alert('Erreur lors de la création');
    console.error(e);
  }
}

async function switchConversation(convId){
  currentConversationId = convId;
  
  try{
    const r = await fetch(API + '/conversations/' + convId);
    if(!r.ok) throw new Error('Erreur');
    
    const data = await r.json();
    const chat = document.getElementById('chat');
    chat.innerHTML = '';
    
    data.messages.forEach(msg => {
      addMessage(msg.content, msg.role === 'user');
    });
    
    if(data.messages.length === 0){
      chat.innerHTML = '<div class="message"><div class="message-content">💬 Conversation vide</div></div>';
    }
    
    loadConversations();
  } catch(e){
    alert('Erreur lors du chargement');
    console.error(e);
  }
}

async function deleteConversation(convId, event){
  event.stopPropagation();
  
  if(!confirm('Supprimer cette conversation ?')) return;
  
  try{
    const r = await fetch(API + '/conversations/' + convId, {method: 'DELETE'});
    if(!r.ok) throw new Error('Erreur');
    
    if(convId === currentConversationId){
      currentConversationId = null;
      document.getElementById('chat').innerHTML = `
        <div class="message">
          <div class="message-content">Conversation supprimée</div>
        </div>
      `;
    }
    
    loadConversations();
  } catch(e){
    alert('Erreur lors de la suppression');
    console.error(e);
  }
}

// 🆕 Fonction améliorée avec détection de source
function addMessage(text, user=false){
  const chat = document.getElementById('chat');
  const msg = document.createElement('div');
  msg.className = `message ${user?'user':''}`;
  
  let content = escapeHtml(text);
  let badge = '';
  
  // 🆕 Détecter la source dans la réponse
  if(!user && text.includes('_Source: Recherche web')){
    const parts = text.split('_Source:');
    content = escapeHtml(parts[0].trim());
    badge = '<div class="source-badge web">🌐 Recherche web</div>';
  } else if(!user && text.includes('_Source: Documents locaux')){
    const parts = text.split('_Source:');
    content = escapeHtml(parts[0].trim());
    badge = '<div class="source-badge local">📚 Documents locaux</div>';
  }
  
  msg.innerHTML = `<div class="message-content">${content}${badge}</div>`;
  chat.appendChild(msg);
  chat.scrollTop = chat.scrollHeight;
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// 🆕 Détection locale de recherche web (indicateur visuel)
function detectWebSearch(question) {
  const webIndicators = [
    'actualité', 'actualités', 'récent', 'aujourd\'hui', 'hier',
    'météo', 'weather', 'news', 'nouveau', 'nouvelle', 'dernière',
    'maintenant', 'cours', 'bourse', 'prix', 'taux'
  ];
  
  const q = question.toLowerCase();
  return webIndicators.some(ind => q.includes(ind));
}

async function sendMessage(){
  if(!currentConversationId){
    alert('Créez ou sélectionnez une conversation');
    return;
  }
  
  const input = document.getElementById('question');
  const q = input.value.trim();
  if(!q) return;
  
  // 🆕 Afficher indicateur si recherche web détectée
  const webStatus = document.getElementById('webStatus');
  if(detectWebSearch(q)){
    webStatus.style.display = 'inline';
    setTimeout(() => webStatus.style.display = 'none', 3000);
  }
  
  addMessage(q, true);
  input.value = '';
  
  const loadingId = 'loading-' + Date.now();
  const chat = document.getElementById('chat');
  const loadingMsg = document.createElement('div');
  loadingMsg.className = 'message';
  loadingMsg.id = loadingId;
  loadingMsg.innerHTML = '<div class="message-content">🤔 Réflexion...</div>';
  chat.appendChild(loadingMsg);
  chat.scrollTop = chat.scrollHeight;
  
  try{
    const r = await fetch(API + '/ask', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({
        question: q,
        conversation_id: currentConversationId
      }),
      signal: AbortSignal.timeout(90000)
    });
    
    document.getElementById(loadingId).remove();
    
    if(!r.ok) throw new Error(`HTTP ${r.status}`);
    
    const d = await r.json();
    addMessage(d.answer || 'Aucune réponse');
    
    loadConversations();
    
  } catch(e){
    if(document.getElementById(loadingId)){
      document.getElementById(loadingId).remove();
    }
    addMessage('❌ Erreur: ' + e.message);
    console.error(e);
  }
}

async function loadDocuments(){
  const box = document.getElementById('docsList');
  box.innerHTML = '<div class="loading">⏳ Chargement...</div>';
  
  try{
    const r = await fetch(API + '/documents');
    if(!r.ok) throw new Error('Erreur');
    
    const docs = await r.json();
    box.innerHTML = '';
    
    if(docs.length === 0){
      box.innerHTML = '<div class="empty">📭 Aucun document</div>';
      return;
    }
    
    docs.forEach(d => {
      const item = document.createElement('div');
      item.className = 'doc-item';
      item.innerHTML = `
        <div class="doc-info">
          <div class="doc-name" title="${escapeHtml(d.name)}">📄 ${escapeHtml(d.name)}</div>
          <div class="doc-id">${escapeHtml(d.id.substring(0, 8))}...</div>
        </div>
        <button class="delete-btn" onclick="deleteDoc('${d.id}', '${escapeHtml(d.name).replace(/'/g, "\\'")}')">🗑️</button>
      `;
      box.appendChild(item);
    });
    
  } catch(e){
    box.innerHTML = '<div class="empty">❌ Erreur</div>';
    console.error(e);
  }
}

async function deleteDoc(id, name){
  if(!confirm(`Supprimer "${name}" ?`)) return;
  
  try{
    const r = await fetch(API + '/documents/' + id, {method: 'DELETE'});
    if(!r.ok) throw new Error('Erreur');
    loadDocuments();
  } catch(e){
    alert('❌ Impossible de supprimer');
    console.error(e);
  }
}

const zone = document.getElementById('uploadZone');
const fileInput = document.getElementById('fileInput');

zone.onclick = () => fileInput.click();
zone.ondragover = e => {e.preventDefault();zone.classList.add('hover')}
zone.ondragleave = () => zone.classList.remove('hover')
zone.ondrop = e => {
  e.preventDefault();
  zone.classList.remove('hover');
  if(e.dataTransfer.files.length > 0) uploadFile(e.dataTransfer.files[0]);
}
fileInput.onchange = () => {
  if(fileInput.files.length > 0) uploadFile(fileInput.files[0]);
}

async function uploadFile(file){
  if(!file) return;
  
  const originalText = zone.innerHTML;
  zone.innerHTML = '⏳ Upload...';
  zone.style.pointerEvents = 'none';
  
  const fd = new FormData();
  fd.append('file', file);
  
  try{
    const r = await fetch(API + '/upload', {method: 'POST', body: fd});
    if(!r.ok) throw new Error('Erreur');
    
    zone.innerHTML = '✅ Ajouté !';
    setTimeout(() => {
      zone.innerHTML = originalText;
      zone.style.pointerEvents = 'auto';
    }, 2000);
    
    loadDocuments();
    fileInput.value = '';
  } catch(e){
    zone.innerHTML = '❌ Erreur';
    setTimeout(() => {
      zone.innerHTML = originalText;
      zone.style.pointerEvents = 'auto';
    }, 2000);
    alert('Erreur upload');
    console.error(e);
  }
}

document.getElementById('question').addEventListener('keypress', (e) => {
  if(e.key === 'Enter' && !e.shiftKey){
    e.preventDefault();
    sendMessage();
  }
});
</script>

</body>
</html>