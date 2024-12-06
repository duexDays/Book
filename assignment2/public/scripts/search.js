//open book popup
function openBookForm(title, ISBN) {
  document.querySelectorAll("#ptitle")[0].textContent = title;
  document.querySelectorAll("#btitle")[0].value = title;
  document.querySelectorAll("#pISBN")[0].value = ISBN;
  document.getElementById("myBookForm").style.display = "block";
}
//close book popup
function closeForm() {
  document.querySelectorAll("#ptitle")[0].textContent = "";
  document.querySelectorAll("#btitle")[0].value = "";
  document.querySelectorAll("#pISBN")[0].value = "";
  document.getElementById("myBookForm").style.display = "none";
}
//Change Book want Type class
function changeWantType(type) {
  var otherType1 = "";
  var otherType2 = "";
  var wantType = "";
  newClassValue = "active";
  var beginDate = "block";
  var endDate = "block";
  var dateText = "Reading Date";
  var star ="grid";
  var reviewText = "Review";
  document.getElementById(type).setAttribute("class", "active");

  if (type == "complete") {
    otherType1 = "reading";
    otherType2 = "want";
    wantType = "1";

  } else if (type == "reading") {
    otherType1 = "complete";
    otherType2 = "want";
    wantType = "2";
    beginDate = "block";
    endDate = "none";
    dateText = "Reading Date";
    star ="none";
    reviewText = "Memo";
  } else {
    otherType1 = "complete";
    otherType2 = "reading";
    wantType = "3";
    beginDate = "none";
    endDate = "none";
    dateText = "";
    star ="none";
    reviewText = "Memo";
  }
  document.querySelectorAll("#wantType")[0].value = wantType;
  document.getElementById(otherType1).setAttribute("class", "");
  document.getElementById(otherType2).setAttribute("class", "");

  document.querySelectorAll(".option-container")[0].style.display = beginDate;
  document.querySelectorAll(".option-container")[1].style.display = endDate;
  document.querySelectorAll("#readingDate")[0].textContent = dateText;
  document.querySelectorAll(".star-layout")[0].style.display = star;
  document.querySelectorAll("#bookReview")[0].textContent = reviewText;
}


// // add event listner to the search filter 
let titleInput = document.querySelector("#ktitle");
titleInput.addEventListener("blur", () => { // arrow function
  if (titleInput.value != "") {
      /*
    if (document.getElementById("searchBook").value == "") {
      document.getElementById("searchBook").value = titleInput.value;
    }
          */
    document.getElementById("filterForm").submit();
  }
});

let authorInput = document.querySelector("#kauthor");
authorInput.addEventListener("blur", () => { // arrow function
  if (authorInput.value != "") {
    /*
    if (document.getElementById("searchBook").value == "") {
      document.getElementById("searchBook").value = authorInput.value;
    }
      */
    document.getElementById("filterForm").submit();
  }
});

let subjectInput = document.querySelector("#subject")[0];
subjectInput.addEventListener("selectionchange", () => { // arrow function
  alert("aa");
  if (subjectInput.value != "") {
          /*
    if (document.getElementById("searchBook").value == "") {
      document.getElementById("searchBook").value = subjectInput.value;
    }
          */
    document.getElementById("filterForm").submit();
  }
});

// onselectionchange version
document.onselectionchange = () => {
  console.log(document.getSelection());
};
