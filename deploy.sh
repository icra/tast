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
  --exclude "db.sqlite" \
  --exclude "deploy.sh" \
  . root@icra.loading.net:/var/www/vhosts/icradev.cat/tast.icradev.cat
