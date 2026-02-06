#check mode debug
cat index.html | grep "let mode_debug"
read -p "continuar? (enter:sí, ctrl+c:no)"

git add *
git commit -am 'update'
git push

#desplega al servidor
# -h  human readable format
# -P  mostra progrés
# -vv incrementa verbositat
# -r  actua recursivament
rsync -hPvr \
  --exclude ".git" \
  --exclude "db/db.sqlite" \
  --exclude "deploy.sh" \
  . root@icra.loading.net:/var/www/vhosts/icradev.cat/tast.icradev.cat
