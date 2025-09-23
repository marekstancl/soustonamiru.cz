# WordPress Development Workflow

## Základní informace
- **Produkce:** http://soustonamiru.cz
- **DEV:** http://localhost:8085  
- **GitHub:** https://github.com/marekstancl/soustonamiru.cz
- **Token:** `[SECURITY: Token odebrán z veřejného repo]`

## Každodenní workflow

### 1. Práce na DEV prostředí
```bash
# Spusť lokální prostředí
cd /opt/docker && docker-compose up -d

# Přejdi do projektu  
cd /opt/www/soustonamiru.cz

# Edituj kód (pluginy, témata)
# Všechno dělej na http://localhost:8085
```

### 2. Commit a push změn
```bash
# Přidej změny
git add .

# Commit s popisem
git commit -m "Popis změny"

# Push do GitHub
git push origin main
```

### 3. Deployment na produkci
```bash
# Spusť deployment skript
./Deployment/deploy.sh
```

## Důležité poznámky

### ✅ Co dělat:
- Všechny změny kódu POUZE na DEV (localhost:8085)
- Vždy commit před deploymentem
- Testuj na DEV před nasazením na produkci

### ❌ Co NEDĚLAT:
- Neupravuj soubory přímo na produkci
- Necommituj wp-config.php (je ignorován)
- Nepřepisuj obsah (uploads/) na produkci

### 📁 Co je sledováno v Git:
- Vaathi téma (`/wp-content/themes/vaathi/`)
- České překlady (`/wp-content/languages/`)
- .gitignore soubor
- Deployment skripty

### 🚫 Co je ignorováno:
- WordPress Core (wp-admin, wp-includes, wp-*.php)
- Všechny pluginy (dokud je nevyfiltrujeme)
- Uživatelský obsah (uploads, cache)
- wp-config.php (kvůli bezpečnosti)

## Řešení problémů

### Pokud něco nefunguje:
```bash
# Zkontroluj status Git
git status

# Zkontroluj remote
git remote -v

# Pull nejnovější změny
git pull origin main
```

### Rollback (vrácení změn):
```bash
# Vrať poslední commit
git revert HEAD

# Push rollback
git push origin main

# Deploy rollback
./Deployment/deploy.sh
```
