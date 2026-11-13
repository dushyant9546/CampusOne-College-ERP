const menu=document.getElementById('menuBtn');if(menu)menu.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('open'));
const toggle=document.getElementById('togglePassword');if(toggle)toggle.addEventListener('click',()=>{const p=document.getElementById('password');p.type=p.type==='password'?'text':'password';toggle.textContent=p.type==='password'?'Show':'Hide';});
