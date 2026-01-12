# 🤖 RAGBot - Assistant Documentaire Intelligent

> **[Français](#français) | [English](#english)**

---

## Français

### 📋 Description

**RAGBot** est un assistant conversationnel intelligent qui utilise la technologie **RAG (Retrieval-Augmented Generation)** pour répondre à vos questions en se basant sur vos documents personnels et/ou des recherches web en temps réel.

**Cas d'usage :**
- 📚 Interroger une bibliothèque de documents (PDF, DOCX, TXT, CSV)
- 🔍 Obtenir des réponses contextualisées et sourcées
- 💬 Maintenir des conversations multi-tours avec historique
- 📥 Exporter vos conversations en plusieurs formats
- 🌐 Combiner connaissances locales et recherches web

---

### ✨ Fonctionnalités

#### 🎯 Cœur du système
- **💬 Gestion de conversations** : Créez, sauvegardez et organisez plusieurs conversations
- **📚 Indexation intelligente** : Upload et vectorisation automatique de documents
- **🔍 RAG avancé** : Recherche sémantique dans ChromaDB avec score de pertinence
- **🌐 Recherche hybride** : Combine documents locaux et recherche web (Serper/Tavily)
- **💾 Historique persistant** : SQLite pour sauvegarder toutes vos conversations

---

### 🛠️ Stack Technique

**Backend (Python/FastAPI)**
- **FastAPI** : API REST haute performance
- **LangChain** : Framework pour applications LLM
- **ChromaDB** : Base de données vectorielle pour le RAG
- **SQLite** : Stockage de l'historique des conversations
- **Python-dotenv** : Gestion sécurisée des variables d'environnement

**Frontend (Vanilla)**
- **HTML5/CSS** : Interface responsive
- **JavaScript** : Logique client sans framework
- **Design** : Dark mode moderne et épuré

**LLM Providers supportés**
- Ollama (local, gratuit)

**Recherche Web**
- Serper API (Google Search)
- Tavily API (optimisée pour LLM)

---

### 📦 Installation

#### Prérequis

- **Python 3.9+** : [Télécharger Python](https://www.python.org/downloads/)
- **pip** : Gestionnaire de paquets Python (inclus avec Python)
- **Git** : [Télécharger Git](https://git-scm.com/)
- **Serveur web** : Apache (XAMPP) ou Python `http.server`
- **Clé API LLM** : OpenAI, Anthropic ou Ollama local

#### Installation pas à pas

##### 1️⃣ Cloner le repository

```bash
# Cloner dans votre dossier de projets
git clone https://github.com/votre-username/ragbot.git
cd ragbot
```

##### 2️⃣ Créer un environnement virtuel

```bash
# Créer l'environnement
python -m venv venv

# Activer l'environnement
# Windows:
venv\Scripts\activate

# Mac/Linux:
source venv/bin/activate
```

##### 3️⃣ Installer les dépendances

```bash
# Installer tous les packages requis
pip install -r requirements.txt

# Vérifier l'installation
pip list
```

##### 4️⃣ Configuration des variables d'environnement

```bash
# Copier le fichier exemple
cp .env.example .env

# Éditer avec votre éditeur préféré
# Windows: notepad .env
# Mac/Linux: nano .env
```

**Configurer votre `.env` :**

```env
# API Configuration
API_HOST=0.0.0.0
API_PORT=8000
CORS_ORIGINS=http://localhost:8080,http://localhost,http://127.0.0.1:8080

# Paths
DATA_PATH=./data
CHROMA_PATH=./chroma

# LLM Provider (choisir UN provider)
OPENAI_API_KEY=sk-votre-clé-openai-ici

# Model Settings
MODEL_NAME=gpt-4
TEMPERATURE=0.7

# Recherche Web (optionnel)
SERPER_API_KEY=votre-clé-serper-ici
```

##### 5️⃣ Démarrer le backend

```bash
# Depuis la racine du projet
python api.py
```

**✅ Vous devriez voir :**
```
INFO:     Uvicorn running on http://0.0.0.0:8000 (Press CTRL+C to quit)
INFO:     Started reloader process
```

##### 6️⃣ Démarrer le frontend

**Option A : Avec Python (recommandé pour développement)**
```bash
# Dans un nouveau terminal
python -m http.server 8080

# Frontend accessible sur : http://localhost:8080
```

**Option B : Avec XAMPP (si déjà installé)**
```bash
# Copier index.html dans C:/xampp/htdocs/
# Démarrer Apache depuis XAMPP Control Panel
# Frontend accessible sur : http://localhost/index.html
```

