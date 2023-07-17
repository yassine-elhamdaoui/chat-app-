var bars = document.getElementsByClassName("bars");
var search = document.getElementsByClassName("search-button");
var choice = document.getElementsByClassName("sidebar-choices");
var send_button = document.getElementsByClassName("fa-solid fa-paper-plane");
var messages_container = document.getElementsByClassName("messages-container");
var messages_section = document.getElementsByClassName("messages-section");
let conversation_display = document.getElementsByClassName(
  "conversation-display"
);
var popup = document.getElementsByClassName("popup");
var search_sidebar = document.getElementById("search");
let conversation_header = document.getElementById("conversation-header");
var send_icon = document.getElementById("send-icon");
var input_area = document.getElementById("input-area");
var mode = document.getElementById("mode");
var mode_in_database = document.getElementById("mode_in_database");
// let conversation_display = document.getElementById("conversation-display");
const sidebar = document.getElementById("sidebar");

var switch_mode = document.getElementById("toggleSwitch");

if (mode.textContent === "dark") {
  switch_mode.checked = true;
} else {
  switch_mode.checked = false;
}

if (switch_mode.checked === true) {
  var body = document.getElementsByTagName("body")[0];
  mode_in_database.textContent = "light";

  body.classList.add("dark-mode");
  for (var i = 0; i < bars.length; i++) {
    bars[i].classList.toggle("white-bars");
  }
  for (var i = 0; i < choice.length; i++) {
    choice[i].classList.toggle("white-sidebar-icons");
  }
  // conversation_display.style.background = url("/chat/images/whatsapp_dark.jpg");
  popup[0].style.background = "#151a25";
  search_sidebar.style.background = "#151a25";
  conversation_display[0].classList.toggle("dark-background");
  conversation_header.style.background = "#1f2937";
  // input_area.style.background = "#fff";
  input_area.style.background = "#1f2937";
  send_icon.style.color = "white";
  messages_section[0].classList.toggle("dark-messages");
  sidebar.style.background = "#151a25";
  // send_button[0].classList.toggle("dark-send");
  messages_container[0].classList.toggle("dark-messages-container");
  // search[0].classList.toggle("white-search");
} else {
  mode_in_database.textContent = "dark";

  var body = document.getElementsByTagName("body")[0];
  body.classList.remove("dark-mode");
  for (var i = 0; i < bars.length; i++) {
    bars[i].classList.remove("white-bars");
  }
  for (var i = 0; i < choice.length; i++) {
    choice[i].classList.remove("white-sidebar-icons");
  }
  search_sidebar.style.background = "#fff";
  popup[0].style.background = "#fff";

  conversation_display[0].classList.remove("dark-background");
  // conversation_header.style.background = "#e1dede";
  conversation_header.style.background = "#fff";
  // input_area.style.background = "#e1dede";
  input_area.style.background = "#fff";
  send_icon.style.color = "black";
  messages_section[0].classList.remove("dark-messages");
  // send_button[0].classList.remove("dark-send");
  sidebar.style.background = "#fff";
  messages_container[0].classList.remove("dark-messages-container");
  // search[0].classList.remove("white-search");
}

document.getElementById("toggleSwitch").addEventListener("change", function () {
  var body = document.getElementsByTagName("body")[0];
  if (this.checked) {
    mode_in_database.textContent = "light";

    body.classList.add("dark-mode");
    for (var i = 0; i < bars.length; i++) {
      bars[i].classList.toggle("white-bars");
    }
    for (var i = 0; i < choice.length; i++) {
      choice[i].classList.toggle("white-sidebar-icons");
    }
    // conversation_display.style.background = url("/chat/images/whatsapp_dark.jpg");
    popup[0].style.background = "#151a25";
    search_sidebar.style.background = "#151a25";
    conversation_display[0].classList.toggle("dark-background");
    conversation_header.style.background = "#1f2937";
    // input_area.style.background = "#fff";
    input_area.style.background = "#1f2937";
    send_icon.style.color = "white";
    messages_section[0].classList.toggle("dark-messages");
    sidebar.style.background = "#151a25";
    // send_button[0].classList.toggle("dark-send");
    messages_container[0].classList.toggle("dark-messages-container");
    // search[0].classList.toggle("white-search");
  } else {
    mode_in_database.textContent = "dark";

    body.classList.remove("dark-mode");
    for (var i = 0; i < bars.length; i++) {
      bars[i].classList.remove("white-bars");
    }
    for (var i = 0; i < choice.length; i++) {
      choice[i].classList.remove("white-sidebar-icons");
    }
    search_sidebar.style.background = "#fff";
    popup[0].style.background = "#fff";

    conversation_display[0].classList.remove("dark-background");
    // conversation_header.style.background = "#e1dede";
    conversation_header.style.background = "#fff";
    // input_area.style.background = "#e1dede";
    input_area.style.background = "#fff";
    send_icon.style.color = "black";
    messages_section[0].classList.remove("dark-messages");
    // send_button[0].classList.remove("dark-send");
    sidebar.style.background = "#fff";
    messages_container[0].classList.remove("dark-messages-container");
    // search[0].classList.remove("white-search");
  }
});
var sidebarChoices = document.querySelectorAll(".sidebar-choices");

sidebarChoices.forEach(function (choice) {
  choice.addEventListener("click", function () {
    var isActive = this.classList.contains("active");

    sidebarChoices.forEach(function (otherChoice) {
      otherChoice.classList.remove("active");
    });

    if (!isActive) {
      this.classList.add("active");
    }
  });
});

const checkbox = document.getElementById("checkbox");
const half_main = document.getElementById("half-main");

checkbox.addEventListener("change", function () {
  var sidebarBackground = window.getComputedStyle(sidebar).backgroundColor;

  if (sidebarBackground === "rgb(255, 255, 255)") {
    if (this.checked) {
      half_main.style.left = "230px";
      half_main.style.width = "calc(100vw - 230px)";
      search_sidebar.style.background = "rgb(223, 223, 223)";
    } else {
      half_main.style.left = "70px";
      half_main.style.width = "calc(100vw - 70px)";
      search_sidebar.style.background = "#fff";
    }
  } else {
    if (this.checked) {
      half_main.style.left = "230px";
      half_main.style.width = "calc(100vw - 230px)";
      search_sidebar.style.background = "#1f2937";
    } else {
      half_main.style.left = "70px";
      half_main.style.width = "calc(100vw - 70px)";
      search_sidebar.style.background = "#151a25";
    }
  }
});

sidebar.onmouseover = function () {
  var sidebarBackground = window.getComputedStyle(sidebar).backgroundColor;
  if (sidebarBackground === "rgb(255, 255, 255)") {
    half_main.style.left = "230px";
    half_main.style.width = "calc(100svw - 230px)";
    search_sidebar.style.background = "rgb(223, 223, 223)";
  } else {
    half_main.style.left = "230px";
    half_main.style.width = "calc(100svw - 230px)";
    search_sidebar.style.background = "#1f2937";
  }
};
sidebar.onmouseleave = function () {
  var sidebarBackground = window.getComputedStyle(sidebar).backgroundColor;

  if (sidebarBackground === "rgb(255, 255, 255)") {
    half_main.style.left = "70px";
    search_sidebar.style.background = "#fff";
    half_main.style.width = "calc(100svw - 70px)";
  } else {
    half_main.style.left = "70px";
    search_sidebar.style.background = "#151a25";
    half_main.style.width = "calc(100svw - 70px)";
  }
};

// Scroll to the bottom of the .conversation-display div
function scrollToBottom() {
  var conversationDisplay = document.getElementById("conversation-display");
  conversationDisplay.scrollTop = conversationDisplay.scrollHeight;
}

// Call scrollToBottom function initially to scroll to the bottom
window.onload = function () {
  scrollToBottom();
};
input_area.addEventListener("onsubmit", function () {
  scrollToBottom();
});
send_button.addEventListener("click", function () {
  scrollToBottom();
});

function showNotAvailableMessage(feature) {
  document.getElementById("popupText").textContent =
    "The " + feature + " calling feature is not available at the moment.";
  document.querySelector(".overlay").style.display = "block";
  document.querySelector(".popup").style.display = "block";
}

function hidePopup() {
  document.querySelector(".overlay").style.display = "none";
  document.querySelector(".popup").style.display = "none";
}

function showMenu() {
  const popupMenu = document.getElementById("popup-menu");

  if (popupMenu.style.display === "none") {
    popupMenu.style.display = "block";
  } else {
    popupMenu.style.display = "none";
  }
}






