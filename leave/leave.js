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



const changeOpts = document.querySelectorAll('.change');

changeOpts.forEach(change => {
    change.addEventListener('click',function(){
        document.getElementById('uname').value = change.innerHTML;
        document.querySelector('.changeOptContainer').style.display = 'block';
    })
});


const unameInput = document.getElementById('uname');

const user = {

}

user.ID = document.querySelector(".uid").innerHtml;

function checkInputType(input) {
    if (!isNaN(parseFloat(input)) && isFinite(input)) {
      return 'Number';
    } else if (typeof input === 'string') {
  
      if (!isNaN(Date.parse(input))) {
        return 'Date';
      } else {
        return 'String';
      }
    } else {
      return 'Unknown';
    }
}

function changeUserDet(){
    var input = unameInput.value;
    if (input != '' && input.length >0) {
        var output = (checkInputType(input));

        if (output === 'Number') {
            user.newId = input;
            document.querySelector('.changeOptContainer').style.display = 'none';
            document.querySelector('.uid').innerHTML = input;
        }else if (output === 'String') {
            user.newName = input;
            document.querySelector('.uname').innerHTML = input;
            document.querySelector('.changeOptContainer').style.display = 'none';
        }else if (output === 'Date') {
            user.newDate = input;
            document.querySelector('.changeOptContainer').style.display = 'none';
            document.querySelector('.udoj').innerHTML = input;
        }else{
            alert('Give the Valid Input ..!');
        }
        console.log(user);
    }else{
        alert('empty request');
    }
}
