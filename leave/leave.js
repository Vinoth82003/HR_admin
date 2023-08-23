const viewbtn = document.querySelector('.view');
const profileSection = document.querySelector('.profileSection');
const closeForm = document.querySelector('.closeForm');
const leaveBtn = document.querySelector('.leaveBtn');

viewbtn.addEventListener('click', function(){
    profileSection.classList.add('active');
    document.querySelector('.formSection').classList.remove('active');
    leaveBtn.style.display ='none';
});

const closeBtn = document.querySelector('.closeProf');

closeBtn.addEventListener('click',function(){
    closeBtn.parentElement.classList.remove('active');
    leaveBtn.style.display ='block';
});



const otherRadioInputs = document.querySelectorAll('input[type="radio"]');
const otherTextArea = document.querySelector('.other');
const otherOption = document.getElementById("other");

otherRadioInputs.forEach(radio => {
    radio.addEventListener('click',function(){
        if (otherOption.checked == true) {
            otherTextArea.style.display = 'flex';
        }else{
            document.getElementById('otherValue').value = '';
            otherTextArea.style.display = 'none';
        }
    })
});



leaveBtn.addEventListener('click',function(){
    document.querySelector('.formSection').classList.add('active');
    leaveBtn.style.display ='none';
});


closeForm.addEventListener('click',function(){
    document.querySelector('.formSection').classList.remove('active');
    leaveBtn.style.display ='block';
});

const user_input = document.querySelectorAll('.user_input');

user_input.forEach(input => {
    input.addEventListener('focus', function() {
        user_input.forEach(userInp => {
            userInp.classList.remove('active');
        });
        input.classList.add('active');
    });
});