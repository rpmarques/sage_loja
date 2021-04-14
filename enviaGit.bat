@echo off
set /p msg=DESCRICAO:
cd\xampp\htdocs\sage_loja
git add -A
git commit -m "%msg%"
git push -u origin main