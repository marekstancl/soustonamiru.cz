#!/bin/bash

echo "🚀 Zahajuji deployment na produkci..."

# 1. Backup produkce
echo "📦 Zálohuji produkční soubory..."
sshpass -p "qO0DvDnUPxgrLUGp@N" ssh soustonamiru_cz@debbie.thinline.cz \
"cd soustonamiru.cz && tar -czf backup_\$(date +%Y%m%d_%H%M%S).tar.gz wp-content/ .git/"

# 2. Pull nových změn
echo "⬇️ Stahuji nové změny z Git..."
sshpass -p "qO0DvDnUPxgrLUGp@N" ssh soustonamiru_cz@debbie.thinline.cz \
"cd soustonamiru.cz && git pull origin main"

# 3. Zkontroluj wp-config.php (produkční verze)
echo "⚙️ Kontroluji wp-config.php..."
sshpass -p "qO0DvDnUPxgrLUGp@N" ssh soustonamiru_cz@debbie.thinline.cz \
"cd soustonamiru.cz && if [ ! -f wp-config.php ]; then echo 'CHYBA: wp-config.php neexistuje!'; exit 1; fi"

# 4. Nastavení práv
echo "🔐 Nastavuji správná práva..."
sshpass -p "qO0DvDnUPxgrLUGp@N" ssh soustonamiru_cz@debbie.thinline.cz \
"cd soustonamiru.cz && chmod -R 755 wp-content/ && chmod 644 wp-config.php"

echo "✅ Deployment dokončen!"
echo "🌐 Zkontroluj: http://soustonamiru.cz"
