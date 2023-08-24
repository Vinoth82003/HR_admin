console.log(`"_leave.js connected..!_"`);

const profileSection = document.querySelector('.profileSection');
const closeForm = document.querySelector('.closeForm');
const leaveBtn = document.querySelector('.leaveBtn');

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
    profileSection.classList.remove('active');
});


closeForm.addEventListener('click',function(){
    document.querySelector('.formSection').classList.remove('active');
    profileSection.classList.add('active');
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

// user
const user = {
}


function writeUser() {
    console.log("___________");
    console.log("User Name : "+user.name);
    console.log("User ID : "+user.id);
    console.log("User DOJ : "+user.doj);
    console.log("___________");
}

function userDetails(){
    let Uname = document.querySelector('.uname');
    let Uid = document.querySelector('.uid');
    let Udoj = document.querySelector('.udoj');
    user.name = Uname.innerHTML;
    user.id = Uid.innerHTML;
    user.doj = Udoj.innerHTML;

    writeUser();
}

userDetails();


const changeOpts = document.querySelectorAll('.change');

changeOpts.forEach(change => {
    change.addEventListener('click',function(){
        alert(change.innerHTML);
    })
});