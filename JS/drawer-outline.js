var button = document.getElementById('openCloseButton');
var drawer = document.getElementById('aside');
var headerOutline = document.querySelector('header')

button.addEventListener('click',()=>{
    drawer.classList.toggle('open')
});

window.addEventListener('scroll',()=>{
    if(window.scrollY>0){
        headerOutline.classList.add('outline');
    }else{
        headerOutline.classList.remove('outline');
    }
});