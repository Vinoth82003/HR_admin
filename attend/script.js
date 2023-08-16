console.log("script.js connected");

const attendStatus = document.querySelectorAll('.status');

attendStatus.forEach(sts => {
    var currentStatus =  sts.innerHTML.toString().toLowerCase();

    if (currentStatus === 'absent') {
        sts.parentElement.children[2].firstElementChild.disabled = true;
        sts.parentElement.children[3].firstElementChild.disabled = true;
        sts.parentElement.style.background = '#ffb9b9';
        sts.parentElement.style.color = '#700707';
    }else if(currentStatus === 'present'){
        sts.parentElement.children[2].firstElementChild.disabled = false;
        sts.parentElement.children[3].firstElementChild.disabled = false;
        sts.parentElement.style.background = '#c9ffc9';
        sts.parentElement.style.color = '#043a04';
    }
});