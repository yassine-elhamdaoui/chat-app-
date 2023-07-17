var id = document.getElementById("account_user_id").value;

$(document).ready(function () {
  $("#search_input").keyup(function () {
    var search = $("#search_input").val();
    $.post(
      "/chat/layout/main/search.php",
      {
        suggestion: search,
      },
      function (data, status) {
        $("#search-result").html(data);
      }
    );
  });
});
$(document).ready(function () {
  $("#search_input2").keyup(function () {
    var search = $("#search_input2").val();
    $.post(
      "/chat/layout/main/search.php",
      {
        suggestion: search,
      },
      function (data, status) {
        $("#search-result").html(data);
      }
    );
  });
});


// 
var lastClickedContactId = null; // Global variable to store the ID of the last clicked contact
var isSendingMessage = false; // Flag to track if a message is currently being sent

function add_message(contactId) {
  
  var form = document.getElementById('input-area');
  var send_icon = document.getElementById('send-icon');
  var messageInput = document.querySelector('.message-input');

  send_icon.addEventListener('click', function (event) {
    event.preventDefault(); // Prevent default form submission
    sendMessage();
  });

  messageInput.addEventListener('keydown', function (event) {
    if (event.keyCode === 13) {
      event.preventDefault(); // Prevent default form submission
      sendMessage();
    }
  });

  function sendMessage() {
    var message = messageInput.value.trim(); // Get the input value and remove leading/trailing whitespace

    if (message === '') {
      console.log('Input is empty');
      return;
    }

    if (isSendingMessage) {
      console.log('A message is already being sent. Please wait.');
      return;
    }

    if (lastClickedContactId !== contactId) {
      console.log('Clicked on a different contact. Message will not be sent.');
      return;
    }

    var xhr = new XMLHttpRequest();
    var queryString = "senderId=" + encodeURIComponent(id) + "&recieverId=" + encodeURIComponent(contactId) + "&message=" + encodeURIComponent(message);

    xhr.open("POST", "/chat/layout/main/add_content.php?" + queryString, true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          console.log('Form submitted successfully!!!');
          messageInput.value = '';
          scrollToBottom();
          // Fetch data after successful form submission
          // fetchData(contactId);
        } else {
          console.error('Error submitting form:', xhr.status);
          // Perform any error handling as needed
        }

        isSendingMessage = false; // Reset the flag after the request is complete
      }
    };

    xhr.send();
    isSendingMessage = true; // Set the flag to indicate that a message is being sent
  }

  // Update the last clicked contact ID
  lastClickedContactId = contactId;
}

function get_selected_contact_infos(contact, imgSrc) {
  var selected_contact_profile_pic = document.getElementById("selected_contact_profile_pic");
  selected_contact_profile_pic.src = imgSrc;

  var selected_contact_infos_name = document.querySelector(".selected_contact_infos h1");
  selected_contact_infos_name.innerHTML = contact.username;

  var selected_contact_infos_status = document.querySelector(".selected_contact_infos h3");
  selected_contact_infos_status.innerHTML = contact.status;

  var selected_contact_infos_email = document.getElementById("email_selected");
  console.log(contact.email);
  console.log(contact.username);
  selected_contact_infos_email.textContent = contact.email;
}

function call_chat_display(contact, imgSrc) {
  var chat_display = document.getElementById("messages-container");
  var header_app = document.getElementById("header_app");
  var sidebarBackground = window.getComputedStyle(sidebar).backgroundColor;
  if (screen.width <= 720) {
    console.log("chhaba ou ha chaba");
    fetchData(contact, imgSrc);
    header_app.style.top = '-13svh';
    chat_display.style.display = 'block';
    chat_display.style.position = 'absolute'
    // chat_display.style.right = '-4px';
    chat_display.style.top = '-65px';
    chat_display.style.left = '-70px';
    chat_display.style.zIndex = '100000';
    if (sidebarBackground === 'rgb(255, 255, 255)') {
      chat_display.style.background = "#fff";
    } else {
      chat_display.style.background = "#111827";

    }
    chat_display.style.width = "100svw";
    chat_display.style.height = "100svh";
  }
  var View_contact = document.getElementById("View_contact");
  View_contact.addEventListener('click', function () {
    get_selected_contact_infos_preview(contact, imgSrc);
  });
}

function go_back_button() {
  var chat_display = document.getElementById("messages-container");
  var header_app = document.getElementById("header_app");
  if (screen.width <= 720) {
    console.log("rja3 awa rja3");
    header_app.style.top = '0';
    chat_display.style.display = 'none';
    chat_display.style.position = 'relative';
    // chat_display.style.right = '4px';

    chat_display.style.top = '65px';
    chat_display.style.zIndex = '100000';
    chat_display.style.background = "#fff";
    chat_display.style.width = "100svw";
    chat_display.style.height = "100svh";
  }
}

function go_back_button_preview() {
  var selected_contact_infos_preview = document.getElementById("selected_contact_infos_preview");
  var popupMenu = document.getElementById("popup-menu");

  if (screen.width <= 720) {
    console.log("rja3 awa rja3");
    selected_contact_infos_preview.style.display = 'none';
    popupMenu.style.display = 'none';
  }
}

function get_selected_contact_infos_preview(contact, imgSrc) {
  var selected_contact_infos_preview = document.getElementById("selected_contact_infos_preview");
  var sidebarBackground = window.getComputedStyle(sidebar).backgroundColor;

  if (screen.width <= 720) {
    get_selected_contact_infos(contact, imgSrc);
    selected_contact_infos_preview.style.display = 'flex';
    selected_contact_infos_preview.style.position = 'absolute'
    // chat_display.style.right = '-4px';
    selected_contact_infos_preview.style.top = '-65px';
    selected_contact_infos_preview.style.left = '-70px';
    selected_contact_infos_preview.style.zIndex = '1200000';
    if (sidebarBackground === 'rgb(255, 255, 255)') {
      selected_contact_infos_preview.style.background = "#fff";
    } else {
      selected_contact_infos_preview.style.background = "#111827";

    }
    selected_contact_infos_preview.style.width = "calc(100svw - 30px)";
    selected_contact_infos_preview.style.height = "100svh";
  }

}

function sendModeToServer() {
  var mode_elem = document.getElementById("mode_in_database");
  var mode = mode_elem.textContent;
  console.log(mode);
  console.log('hhhhhhhhhhhhhhhhhhhhhhh');
  // Create an AJAX request
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/chat/layout/main/update_mode.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Send the mode value to the server-side script
  xhr.send("mode=" + encodeURIComponent(mode));
}


function checkOrCreateConversation(receiverId) {
  var xhr = new XMLHttpRequest();
  var senderId = id;
  var queryString = "senderId=" + encodeURIComponent(senderId) + "&receiverId=" + encodeURIComponent(receiverId);
  console.log(receiverId);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = xhr.responseText;
      console.log(receiverId);
      console.log(response); // Process the response as needed
    }
  };

  xhr.open(
    "GET","/chat/layout/main/add_conversation.php?" + queryString,true);
  xhr.send();
  fetchContacts(); //back bla mandir reload l la page!!
}
//adding the event listner to the elemet directly wont work !!!! 7di rask 
//l event kaytzad 9bal mayt attacha l element l DOM !!
document.addEventListener('click', function (event) {
  var target = event.target;
  if (target.id === 'search-div-contact') {
    var pElement = target.querySelector('p');
    if (pElement) {
      var receiverId = pElement.textContent;
      console.log(receiverId);
      checkOrCreateConversation(receiverId);

    }
  }
});

//the ajax code
var activeRequest = null;
var pollingInterval = 10;

function fetchData(contact, imgSrc) {
  if (activeRequest) {
    activeRequest.abort();
  }

  var xhr = new XMLHttpRequest();

  var queryString = "senderId=" + encodeURIComponent(id) + "&recieverId=" + encodeURIComponent(contact.user_id);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {

      var response = JSON.parse(xhr.responseText);
      var dataContainer = document.getElementById("conversation-display");
      var profile_pic_contact = document.getElementById("profile_pic_contact");
      profile_pic_contact.src = imgSrc;
      var contact_status = document.getElementById("contact_status");
      contact_status.textContent = contact.status;
      // Clear previous data
      dataContainer.innerHTML = "";
      let previousSenderID = null; // Keep track of the previous sender ID

      // Iterate through the retrieved data and display it
      response.forEach(function (message) {
        var p = document.createElement("p");
        var section = document.createElement("section");
        var div = document.createElement("div");
        var reciver_container = document.createElement("div");
        reciver_container.classList.add("conversation-display-reciver");
        var time = document.createElement("h6");
        var reciever_img = document.createElement("img");
        if (message.sender_id == id || message.reciever_id == id) {
          if (message.sender_id == id) {
            time.textContent = formatTime(message.sent_at);
            time.style.color = "rgba(0,0,0,0.7)";
            time.style.margin = "0 -3px 0 0";
            time.style.fontSize = "9px";
            time.style.textAlign = "end";

            p.textContent = message.content;
            p.appendChild(time);
            section.appendChild(p);
            dataContainer.appendChild(section);
            previousSenderID = null
            // scrollToBottom();
          } else if (message.reciever_id == id) {
            time.textContent = formatTime(message.sent_at);
            time.style.color = "rgba(0,0,0,0.7)";
            time.style.margin = "0 -3px 0 0";
            time.style.fontSize = "9px";
            time.style.textAlign = "end";
            if (message.sender_id !== previousSenderID) {
              // Display the image only if the sender ID is different from the previous one
              reciever_img.src = imgSrc;
              reciver_container.appendChild(reciever_img);
            }
            if (reciever_img.src !== imgSrc) {
              reciver_container.style.paddingLeft = '42px'
            }
            // reciever_img.src = imgSrc;
            div.textContent = message.content;
            div.appendChild(time);
            // reciver_container.appendChild(reciever_img);
            reciver_container.appendChild(div);
            dataContainer.appendChild(reciver_container);
            previousSenderID = message.sender_id; // Update the previous sender ID
            // scrollToBottom();
          }
        }
      });

      function formatTime(timestamp) {
        var date = new Date(timestamp);
        var options = {
          hour: 'numeric',
          minute: 'numeric'
        };
        return date.toLocaleTimeString('en-US', options);
      }


      // Fetch data again after the specified polling interval
      setTimeout(function () {
        fetchData(contact, imgSrc);
      }, pollingInterval);
    }
  };

  xhr.open("GET", "/chat/layout/main/get_messages.php?" + queryString, true);
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.send();
  activeRequest = xhr;
}


// Fetch data initially
// fetchData();


function fetchContacts() {
  var xhr = new XMLHttpRequest();

  // Create the query string with the id parameter
  var queryString = "id=" + encodeURIComponent(id);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      var messagesContainer = document.getElementById("messages");

      // Clear previous data
      messagesContainer.innerHTML = "";

      // Iterate through the retrieved data and create a message box for each contact
      response.forEach(function (contact) {
        var messageBox = document.createElement("div");
        messageBox.classList.add("message-box");

        var img = document.createElement("img");
        var imageRequest = new XMLHttpRequest();
        var imgSrc;
        imageRequest.onreadystatechange = function () {
          if (imageRequest.readyState === 4 && imageRequest.status === 200) {
            // Process the response and set the image source
            var profilePictureData = imageRequest.responseText;
            imgSrc = profilePictureData;

            img.src = imgSrc;
          }
        };
        // Make the HTTP request to retrieve the profile picture
        imageRequest.open("GET","/chat/layout/main/get_profile_picture.php?user_id=" +contact.user_id,true);
        imageRequest.send();
        img.alt = "";

        var messageContent = document.createElement("div");
        messageContent.classList.add("message-content");

        var messageHeader = document.createElement("div");
        messageHeader.classList.add("message-header");

        var name = document.createElement("div");
        name.classList.add("name");
        name.textContent = contact.username;

        var starCheckbox = document.createElement("div");
        starCheckbox.classList.add("star-checkbox");

        var inputCheckbox = document.createElement("input");
        inputCheckbox.type = "checkbox";
        inputCheckbox.id = "star-1";

        var label = document.createElement("label");
        label.htmlFor = "star-1";

        var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
        svg.setAttribute("width", "20");
        svg.setAttribute("height", "20");
        svg.setAttribute("viewBox", "0 0 24 24");
        svg.setAttribute("fill", "none");
        svg.setAttribute("stroke", "currentColor");
        svg.setAttribute("stroke-width", "2");
        svg.setAttribute("stroke-linecap", "round");
        svg.setAttribute("stroke-linejoin", "round");
        svg.classList.add("feather", "feather-star");

        var polygon = document.createElementNS("http://www.w3.org/2000/svg", "polygon");
        polygon.setAttribute("points", "12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2");

        svg.appendChild(polygon);
        label.appendChild(svg);
        starCheckbox.appendChild(inputCheckbox);
        starCheckbox.appendChild(label);
        messageHeader.appendChild(name);
        messageHeader.appendChild(starCheckbox);
        messageContent.appendChild(messageHeader);

        var messageLine = document.createElement("p");
        messageLine.classList.add("message-line");
        messageLine.style.opacity = "0.6";

        var messageTime = document.createElement("p");
        messageTime.classList.add("message-line", "time");

        messageContent.appendChild(messageLine);
        messageContent.appendChild(messageTime);

        messageBox.appendChild(img);
        messageBox.appendChild(messageContent);
        messageBox.addEventListener('click', function () {
          console.log("Clicked on contact:", contact.username);
          var clicked_contact_name = document.getElementById("clicked-contact-name");
          clicked_contact_name.textContent = contact.username;
          fetchData(contact, imgSrc);
          add_message(contact.user_id);
          scrollToBottom();
          call_chat_display(contact, imgSrc);
          if (screen.width > 720) {
            get_selected_contact_infos_preview(contact, imgSrc);
          }
          get_selected_contact_infos(contact, imgSrc);
        });

        messagesContainer.appendChild(messageBox);

        // Fetch last message for the current contact
        fetchLastMessage(contact.user_id, messageLine, name, messageTime);

      });
    }
  };

  xhr.open("GET", "/chat/layout/main/get_contacts.php?" + queryString, true);
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.send();
}

// Fetch data initially
fetchContacts();

var pollingIntervale = 2000;

function fetchLastMessage(contactId, textContainer, contactName, messageTime) {


  var xhr = new XMLHttpRequest();
  var queryString = "senderId=" + encodeURIComponent(id) + "&recieverId=" + encodeURIComponent(contactId);
  // console.log(contactId);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);

      // Clear previous data
      textContainer.innerHTML = "";
      // console.log(textContainer.textContent);
      // Iterate through the retrieved data and display it
      if (response.length > 0) {
        var message = response[0];
        if (message.sender_id == id) {
          // console.log(textContainer.textContent);
          if (message.content.length < 15) {
            textContainer.textContent = "you:" + message.content;
          } else {
            textContainer.textContent = "you:" + message.content.substring(0, 15) + "...";
          }
          messageTime.textContent = formatDate(message.sent_at);
          // scrollToBottom();
        } else if (message.reciever_id == id) {
          // console.log(textContainer.textContent);
          if (message.content.length < 15) {
            textContainer.textContent = contactName.textContent + ":" + message.content;
          } else {
            textContainer.textContent = contactName.textContent + ":" + message.content.substring(0, 15) + "...";

          }
          messageTime.textContent = formatDate(message.sent_at);

          // scrollToBottom();
        }
      }
      // Fetch data again
      setTimeout(function () {
        fetchLastMessage(contactId, textContainer, contactName, messageTime);
      }, pollingIntervale);

    }
  };

  xhr.open("GET","/chat/layout/main/get_last_message.php?" + queryString , true);
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.send();


}

function formatDate(timestamp) {
  var date = new Date(timestamp);
  var options = {
    month: 'long',
    day: 'numeric'
  };
  return date.toLocaleDateString('en-US', options);
}

// sending the messages and stuff by using the form submition !!
// it has some proplems that i fixed with just simple js 
    // var lastClickedContactId = null; // Global variable to store the ID of the last clicked contact
    // var isSendingMessage = false; // Flag to track if a message is currently being sent

    // function add_message(contactId) {
    //   var id = <?php echo $id; ?>;
    //   var queryString = "senderId=" + encodeURIComponent(id) + "&recieverId=" + encodeURIComponent(contactId);
    //   var form = document.getElementById('input-area');

    //   form.addEventListener('submit', function(event) {
    //     event.preventDefault(); // Prevent default form submission
    //     var messageInput = document.querySelector('.message-input');
    //     var message = messageInput.value.trim(); // Get the input value and remove leading/trailing whitespace

    //     if (message === '') {
    //       console.log('Input is empty');
    //       return;
    //     }

    //     if (isSendingMessage) {
    //       console.log('A message is already being sent. Please wait.');
    //       return;
    //     }

    //     if (lastClickedContactId !== contactId) {
    //       console.log('Clicked on a different contact. Message will not be sent.');
    //       return;
    //     }


    //     var xhr = new XMLHttpRequest();
    //     var formData = new FormData(form);
    //     xhr.open('POST', 'add_content.php?' + queryString, true);

    //     xhr.onreadystatechange = function() {
    //       if (xhr.readyState === XMLHttpRequest.DONE) {
    //         if (xhr.status === 200) {
    //           console.log('Form submitted successfully!!!');
    //           messageInput.value = '';
    //           scrollToBottom();
    //           // Fetch data after successful form submission
    //           // fetchData(contactId);
    //         } else {
    //           console.error('Error submitting form:', xhr.status);
    //           // Perform any error handling as needed
    //         }

    //         isSendingMessage = false; // Reset the flag after the request is complete
    //       }
    //     };
    //     xhr.send(formData);
    //     isSendingMessage = true; // Set the flag to indicate that a message is being sent

    //     // Remove the event listener after initializing the request
    //     form.removeEventListener('submit', arguments.callee);

    //   });

    //   // Update the last clicked contact ID
    //   lastClickedContactId = contactId;
    // }