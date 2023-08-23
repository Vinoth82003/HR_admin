const viewbtn = document.querySelector('.view');
const profileSection = document.querySelector('.profileSection');

viewbtn.addEventListener('click', function(){
    profileSection.classList.add('active');
});

const closeBtn = document.querySelector('.closeProf');

closeBtn.addEventListener('click',function(){
    closeBtn.parentElement.classList.remove('active');
})