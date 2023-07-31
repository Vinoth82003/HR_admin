console.log(`logged`);

const filterinput = document.getElementById("filterinput");
const boxs = document.querySelectorAll(".user");
filterinput.addEventListener("input", function () {
  var inputVal = filterinput.value;

  if (inputVal === "" || inputVal.length <= 0) {
    boxs.forEach((box) => {
      box.style.display = "flex";
    });
  } else {
    if (!isNaN(inputVal)) {
      boxs.forEach((box) => {
        var id = box.getAttribute("index");
        if (id.includes(inputVal)) {
          box.style.display = "flex";
        } else {
          box.style.display = "none";
        }
      });
    } else {
      var uname = document.querySelectorAll(".username");
      uname.forEach((name) => {
        if (name.innerHTML.toLowerCase().includes(inputVal.toLowerCase())) {
          name.parentElement.parentElement.style.display = "flex";
        } else {
          console.log(name.innerHTML + "-" + inputVal);
          name.parentElement.parentElement.style.display = "none";
        }
      });
    }
  }
});

const selects = document.querySelectorAll("#usercheck");

selects.forEach((slct) => {
  slct.addEventListener("click", function () {
    if (slct.checked === true) {
      slct.parentElement.parentElement.parentElement.classList.add("active");
    } else {
      slct.parentElement.parentElement.parentElement.classList.remove("active");
    }
  });
});

const delbtns = document.querySelectorAll(".del");

delbtns.forEach((btn) => {
  btn.addEventListener("click", function () {
    var id =
      btn.parentElement.parentElement.parentElement.getAttribute("index");
    var name =
      btn.parentElement.parentElement.nextElementSibling.children[1].innerHTML;

    btn.parentElement.parentElement.children[0].children[0].checked = true;
    delsect();

    document.querySelector(".confirmBox").classList.add("active");
    document.querySelector(
      ".text"
    ).innerHTML = `Are you Sure to Delete  <u> ${name} </u> ?`;
    document.querySelector(".cancel").addEventListener("click", function () {
      document.querySelector(".confirmBox").classList.remove("active");
    });
    document.querySelector(".confirm").addEventListener("click", function () {
      document.querySelector(".confirmBox").classList.remove("active");
      btn.parentElement.parentElement.parentElement.remove();
    });
  });
});

function delsect() {
  selects.forEach((slct) => {
    if (slct.checked === true) {
      slct.parentElement.parentElement.parentElement.classList.add("active");
    } else {
      slct.parentElement.parentElement.parentElement.classList.remove("active");
    }
  });
}

const indicate = document.querySelectorAll(".indicate");
const filter_btn = document.querySelectorAll(".filter-btn");

filter_btn.forEach((btn) => {
  btn.addEventListener("click", function () {
    var btnVal = btn.innerHTML.toLowerCase();
    if (btnVal === "all") {
      boxs.forEach((box) => {
        box.style.display = "flex";
      });
    } else {
      indicate.forEach((ind) => {
        if (ind.innerHTML.toLowerCase().includes(btnVal)) {
          ind.parentElement.parentElement.parentElement.style.display = "flex";
        } else {
          ind.parentElement.parentElement.parentElement.style.display = "none";
        }
      });
    }
  });
});
