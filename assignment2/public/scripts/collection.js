//open book popup
function openBookForm(title, ISBN, wantType, startDate, endDate, review, rating) {
  document.querySelectorAll("#ptitle")[0].textContent = title;
  document.querySelectorAll("#btitle")[0].value = title;
  document.querySelectorAll("#pISBN")[0].value = ISBN;
  document.querySelectorAll("#wantType")[0].value = wantType;
  document.querySelectorAll("#startDate")[0].value = startDate;
  document.querySelectorAll("#endDate")[0].value = endDate;
  document.querySelectorAll("#review")[0].value = review;
  if (rating != "" && rating != null) {
    if (rating=="1") document.getElementById("1-stars").checked = true;
    if (rating=="2") document.getElementById("2-stars").checked = true;
    if (rating=="3") document.getElementById("3-stars").checked = true;
    if (rating=="4") document.getElementById("4-stars").checked = true;
    if (rating=="5") document.getElementById("5-stars").checked = true;
  }
  var wantText = "";
  if (wantType == "1") {
    document.getElementById("buttonReading").style.display = "none";
    document.getElementById("buttonWant").style.display = "none";
    wantText = "complete";
  } else if (wantType == "2") {
    document.getElementById("buttonReading").style.display = "block";
    document.getElementById("buttonWant").style.display = "none";
    wantText = "reading";
  } else {
    document.getElementById("buttonReading").style.display = "block";
    document.getElementById("buttonWant").style.display = "block";
    wantText = "want";
  }
  changeWantType(wantText);
  document.getElementById("myBookForm").style.display = "block";
}
//close book popup
function closeForm() {
  document.querySelectorAll("#ptitle")[0].textContent = "";
  document.querySelectorAll("#btitle").value = "";
  document.querySelectorAll("#pISBN").value = "";
  document.getElementById("myBookForm").style.display = "none";
}

//delete book
function deleteBook() {
  if (confirm("Do you want this book form your collection?")) {
    document.getElementById("delete").value = "X";
    document.getElementById("bookForm").submit();
  }
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
  var star = "grid";
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
    star = "none";
    reviewText = "Memo";
  } else {
    otherType1 = "complete";
    otherType2 = "reading";
    wantType = "3";
    beginDate = "none";
    endDate = "none";
    dateText = "";
    star = "none";
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
