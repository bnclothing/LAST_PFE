<?php
include("../../php/database.php");
session_start();

$cmp = 0;
if ($_SESSION["login"] == 1) {
    $cmp = 1;
}
if ($cmp == 0) {
    header("location:../../");
}

// Fetch all groups based on the selected chat type
$chatType = isset($_GET['chat_type']) ? $_GET['chat_type'] : 'all';

$groups = [];
if ($chatType == 'all') {
    // Fetch all groups
    $stmt = $db->prepare("SELECT * FROM groupdiscussion WHERE TYPE = 1 AND ID_GROUP_DISCUSSION IN (SELECT ID_GROUP_DISCUSSION FROM groupmembership WHERE ID_USER = ?)");
    $stmt->execute([$_SESSION["id_user"]]);
    $stmt->execute();
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($chatType == 'students') {
    // Fetch groups with students
    $stmt = $db->prepare("SELECT * FROM groupdiscussion WHERE TYPE = 3 AND ID_GROUP_DISCUSSION IN (SELECT ID_GROUP_DISCUSSION FROM groupmembership WHERE ID_USER = ?)");
    $stmt->execute([$_SESSION["id_user"]]);
    $stmt->execute();
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($chatType == 'teachers') {
    // Fetch groups with teachers
    $stmt = $db->prepare("SELECT * FROM groupdiscussion WHERE TYPE = 2 AND ID_GROUP_DISCUSSION IN (SELECT ID_GROUP_DISCUSSION FROM groupmembership WHERE ID_USER = ?)");
    $stmt->execute([$_SESSION["id_user"]]);
    $stmt->execute();
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch messages for the selected group
$selectedGroupID = isset($_GET['group_id']) ? $_GET['group_id'] : '';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../../css/chat.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/all.css">
</head>

<body>
    <div class="container">
        <div class="side1">
            <div class="nav">
                <div class="back">
                    <button onclick="goBack()">Go Back</button>
                </div>



                <div class="chat_type">
                    <form action="" method="get">
                        <select name="chat_type" onchange="updateGroupId(this)">
                            <option value="all" <?php echo ($chatType == 'all') ? 'selected' : ''; ?>>All Chat</option>
                            <?php if ($_SESSION["name_role"] != 'teacher') : ?>
                                <option value="students" <?php echo ($chatType == 'students') ? 'selected' : ''; ?>>Students</option>
                            <?php endif; ?>
                            <?php if ($_SESSION["name_role"] != 'student') : ?>
                                <option value="teachers" <?php echo ($chatType == 'teachers') ? 'selected' : ''; ?>>Teachers</option>
                            <?php endif; ?>
                        </select>
                        <input autocomplete="off" type="hidden" id="group_id" name="group_id" value="<?php echo isset($_GET['group_id']) ? $_GET['group_id'] : '1'; ?>">
                    </form>


                </div>
            </div>
            <div class="contacts">
                <?php
                // Display groups
                if (!empty($groups)) {
                    foreach ($groups as $group) {
                        // Check if the group ID matches the selected group ID
                        // Set the default image and entity type
                        $image = '../../assets/images/global.svg';
                        $entityType = 'Global';
                        // Update the image and entity type based on the entity_type value
                        if ($group['entity_type'] == 'Filliere') {
                            $image = '../../assets/images/filliere.svg';
                            $entityType = 'Filliere';
                        } elseif ($group['entity_type'] == 'Module') {
                            $image = '../../assets/images/module.svg';
                            $entityType = 'Module';
                        } elseif ($group['entity_type'] == 'Department') {
                            $image = '../../assets/images/department.svg';
                            $entityType = 'Department';
                        }

                        echo '<ul class="group">';
                        $activeClass = ($selectedGroupID == $group['ID_GROUP_DISCUSSION']) ? 'active' : '';

                        echo '<li class="tag-parent ' . $entityType . ' ' . $activeClass . '" onclick="redirectToChild(this)">';
                        echo '<div class="contact-item">';
                        echo '<div class="contact-image"><img src="' . $image . '" alt="' . $group['NAME'] . '"></div>';
                        echo '<div class="contact-text">';
                        echo '<div class="tag ' . $entityType . '"></div>';
                        echo '<div class="contact-title"><a href="?chat_type=' . $chatType . '&group_id=' . $group['ID_GROUP_DISCUSSION'] . '">' . $group['NAME'] . '</a></div>';
                        echo '<div id="last-message-' . $group['ID_GROUP_DISCUSSION'] . '" class="last-message"></div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</li>';
                        
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </div>

        <div class="side2">
            <div class="nav">
                <?php
                // Display group name
                if (!empty($selectedGroupID)) {
                    $stmt = $db->prepare("SELECT NAME FROM groupdiscussion WHERE ID_GROUP_DISCUSSION = :group_id");
                    $stmt->bindParam(':group_id', $selectedGroupID, PDO::PARAM_INT);
                    $stmt->execute();
                    $groupName = $stmt->fetchColumn();
                    if ($groupName) {
                        echo '<div class="group_infos">';
                        echo '<h3>' . $groupName . '</h3>';
                        echo '</div>';
                    }
                }
                ?>
                <div class="dropdown">
                    <i class="fa-solid fa-bars fa-large menuBtn" onclick="showMenu(this)"></i>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="#">item 1</a>
                        <a href="#">item 2</a>
                        <a href="#">item 3</a>
                        <a href="#">item 4</a>
                        <a href="#">item 5</a>
                    </div>
                </div>
            </div>
            <div class="chat-container">
                <ol class="chat">
                    
                </ol>
                <div id="spinner" style="display: none;">
                        <div class="spinner-content">
                            <i class="fa fa-spinner fa-spin"></i> Loading...
                        </div>
                </div>
            </div>
            <div class="text">
                <form id="sendMessageForm" class="input-group" method="post">
                    <input autocomplete="off" type="hidden" name="group_id" value="<?php echo $selectedGroupID; ?>">
                    <input autocomplete="off" type="hidden" name="chat_type" value="<?php echo $chatType; ?>">
                    <input type="file" name="file_upload" id="file_upload" style="display: none;" onchange="handleFileSelection(event);">

                    <div class="import" id="plusBtn" onclick="document.getElementById('file_upload').click();">
                        <i class="fa fa-plus"></i>
                    </div>

                    <div class="import" id="cancelBtn" style="display: none;" onclick="resetAll()">
                        <i class="fa-solid fa-xmark"></i>
                    </div>

                    <div class="input-container">
                        <input type="text" name="message_content" id="message_content" autocomplete="off" oninput="toggleRecordingButton()">
                        <audio id="audioPlayer" controls style="display: none;"></audio>
                    </div>
                    <div class="btn-container" id="btnContainer">
                        <button class="sent" id="sendButton" style="display: none;"><i class="fa fa-paper-plane fa-xl"></i></button>
                        <button class="sent" id="sendAudio" style="display: none;" onclick="sendAudioFile()"><i class="fa fa-paper-plane fa-xl"></i></button>
                        <button class="sent" id="startRecordingButton" onclick="startRecording()"><i class="fa fa-microphone fa-xl"></i></button>
                        <button class="sent flicker" id="stopRecordingButton" onclick="stopRecording()" style="display: none;"><i class="fa fa-microphone fa-xl"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Hidden modal for displaying the file -->
    <div id="fileModal" class="modal">
        <div class="modal-content">

        </div>
    </div>

    <script>
        function updateLastMessage(groupID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('last-message-' + groupID).innerHTML = xhr.responseText;
                } else {
                    document.getElementById('last-message-' + groupID).innerHTML = 'Error fetching last message';
                }
            }
        };
        xhr.open('GET', 'get_last_message.php?group_id=' + groupID, true);
        xhr.send();
    }

    function updateLastMessages() {
        <?php foreach ($groups as $group) : ?>
            updateLastMessage(<?php echo $group['ID_GROUP_DISCUSSION']; ?>);
        <?php endforeach; ?>
    }

    // Initial call to update last messages
    updateLastMessages();

    setInterval(updateLastMessages, 500); 
    </script>

    <script>
        let mediaRecorder;
        let audioChunks = [];
        let audioPlayer = document.getElementById('audioPlayer');
        let recordedAudioBlob;

        function toggleRecordingButton() {
            const messageContent = document.getElementById('message_content').value.trim();
            const sendButton = document.getElementById('sendButton');
            const startRecordingButton = document.getElementById('startRecordingButton');
            const btnContainer = document.getElementById('btnContainer');

            if (messageContent === '') {
                sendButton.style.display = 'none';
                startRecordingButton.style.display = 'block';
            } else {
                sendButton.style.display = 'block';
                startRecordingButton.style.display = 'none';
            }
        }

        const startRecording = () => {



            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };
                    mediaRecorder.start();
                    document.getElementById('startRecordingButton').style.display = "none";
                    document.getElementById('stopRecordingButton').style.display = "block";
                })
                .catch(err => {
                    console.error('Error accessing microphone:', err);
                    alert('Please enable microphone access to use this feature.');
                });
        };

        const stopRecording = () => {
            mediaRecorder.stop();
        };



        document.getElementById('startRecordingButton').addEventListener('click', () => {
            startRecording();
        });

        document.getElementById('stopRecordingButton').addEventListener('click', () => {
            stopRecording();
            document.getElementById('sendAudio').style.display = "block";
            document.getElementById('stopRecordingButton').style.display = "none";

            mediaRecorder.ondataavailable = event => {
                recordedAudioBlob = event.data; // Store the audio blob
                const audioUrl = URL.createObjectURL(recordedAudioBlob);
                audioPlayer.src = audioUrl;
                document.getElementById('message_content').style.display = 'none';
                document.getElementById('plusBtn').style.display = 'none';
                document.getElementById('cancelBtn').style.display = 'flex';
                audioPlayer.style.display = 'block';
            };
        });

        function sendAudioFile() {
            var groupId = document.getElementById('group_id').value; // Get the group_id from the hidden input

            var formData = new FormData();
            formData.append('group_id', groupId);
            formData.append('file_upload', recordedAudioBlob, 'audio.wav'); // Use the stored audio blob

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_audio.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Fetch new messages to update the chat
                    fetchNewMessages();
                    updateLastMessages();
                    resetAll();
                }
            };
            xhr.send(formData); // Send the request with form data
        }



        function resetAll() {
            document.getElementById('message_content').value = '';
            document.getElementById('audioPlayer').style.display = 'none';
            document.getElementById('message_content').style.display = 'block';
            document.getElementById('plusBtn').style.display = 'flex';
            document.getElementById('cancelBtn').style.display = 'none';
            document.getElementById('startRecordingButton').style.display = 'block';
            document.getElementById('stopRecordingButton').style.display = 'none';
            document.getElementById('sendButton').style.display = 'none';
            document.getElementById('sendAudio').style.display = 'none';
            audioChunks = []; // Clear the audio chunks array
        }
    </script>


    <script>
        function showMenu(btn) {
            var myDropdown = document.getElementById("myDropdown");
            myDropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.menuBtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show') && !event.target.closest('.dropdown-content')) {
                        openDropdown.classList.remove('show');
                        resetStyles();
                    }
                }
            }
        };
    </script>
    <script>
        // Function to handle file selection and display modal
        function handleFileSelection(event) {
            event.preventDefault();
            var file = event.target.files[0];
            var fileReader = new FileReader();
            const fileName = file.name;
            const fileSize = file.size;

            function formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';

                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }

            // Assuming fileSize is in bytes
            const fileSizeFormatted = formatBytes(fileSize);

            // Check if file size exceeds 100MB
            if (fileSize > 100 * 1024 * 1024) {
                alert('File size exceeds 100MB. Please select a smaller file.');
                return;
            }

            var modalContent = document.querySelector('.modal-content');

            // Show the spinner
            var spinner = document.getElementById('spinner');
            spinner.style.display = 'block';

            fileReader.onload = function() {
                var modalContent = document.querySelector('.modal-content');
                var fileExtension = file.name.split('.').pop().toLowerCase();
                var filePreviewHtml;

                if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(fileExtension)) {
                    filePreviewHtml = '<img id="filePreview" src="' + fileReader.result + '" alt="File Preview">';
                } else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
                    filePreviewHtml = '<video id="filePreview" src="' + fileReader.result + '" controls></video>';
                } else if (['mp3', 'wav', 'ogg'].includes(fileExtension)) {
                    filePreviewHtml = '<audio id="filePreview" src="' + fileReader.result + '" controls></audio>';
                } else if (fileExtension === 'pdf') {
                    filePreviewHtml = '<iframe src="' + fileReader.result + '" type="application/pdf" ></iframe>';
                } else {
                    filePreviewHtml = `<button class="last-line-standing">
                <div class="informations">
                    <i class="fa-solid fa-file" style="font-size:5rem"></i>
                    <p>${fileName}</p>
                    <p>${fileSizeFormatted}</p>
                </div>
            </button>`;
                }

                modalContent.innerHTML = `
<div class="close-container">
    <i class="fa-solid fa-close close" onclick="closeModal()"></i>
</div>
<div class="preview">
    <div class="pre-container">
        ${filePreviewHtml}
    </div>
</div>
<div class="send-btn-container">
    <button onclick="sendMessageWithFile()" id="sendFileBtn" class="sent"><i class="fa-solid fa-paper-plane"></i></button>
</div>
`;


                var modal = document.getElementById('fileModal');
                modal.style.display = "block";
                setTimeout(() => {
                    modal.classList.add("show-preview");
                    spinner.style.display = 'none';
                }, 100);
            };

            fileReader.readAsDataURL(file);
        }



        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById('fileModal');
            modal.classList.remove("show-preview");
            resetFilePreview();
        }


        function closeModal2() {
            var modal = document.getElementById('fileModal');
            modal.style.display = "none";
            modal.classList.remove("show-preview");
            resetFilePreview();
        }

        // Function to send message with file
        function sendMessageWithFile() {
            var groupId = document.getElementById('group_id').value; // Get the group_id from the hidden input
            var file = document.getElementById('file_upload').files[0]; // Get the uploaded file

            var formData = new FormData();
            formData.append('group_id', groupId);
            formData.append('file_upload', file);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_file.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Fetch new messages to update the chat
                    fetchNewMessages();
                    updateLastMessages();
                    // Close the modal
                    closeModal2();

                }
            };
            xhr.send(formData); // Send the request with form data
        }


function resetFilePreview() {
    var modalContent = document.querySelector('.modal-content');
    modalContent.innerHTML = '';
}
    </script>


    <script>
        function goBack() {
            window.location.href = "../home/";
        }
    </script>
    <script>
        function redirectToChild(element) {
            var anchor = element.querySelector('a');
            if (anchor) {
                var url = anchor.getAttribute('href');
                window.location.href = url;
            }
        }
    </script>
    <script>
        function updateGroupId(select) {
            var groupIdInput = document.getElementById('group_id');
            if (select.value === 'students') {
                groupIdInput.value = '3';
            } else if (select.value === 'teachers') {
                groupIdInput.value = '2';
            } else {
                groupIdInput.value = '1';
            }
            // Optionally, you can submit the form automatically after updating the group_id
            select.form.submit();
        }
    </script>

    <script>
        // Fetch messages once when the page loads
        fetchMessages();

        function displayMessages(messages) {
            let prevDate = null;
            let firstMessageID = null;
            let lastMessageID = null;
            let html = '';

            messages.forEach((message, index) => {
                    if (index === 0) {
                        firstMessageID = message.ID_MESSAGE;
                    }
                    lastMessageID = message.ID_MESSAGE;

                    const currentDate = new Date(message.TIMESTAMP);
                    const formattedDate =
                        currentDate.toDateString() === new Date().toDateString() ?
                        'Today' :
                        currentDate.toDateString() === new Date(Date.now() - 86400000).toDateString() ?
                        'Yesterday' :
                        currentDate.toLocaleDateString();

                    if (formattedDate !== prevDate) {
                        html += `<hr class="hr-text" data-content="${formattedDate}"> `;
                        prevDate = formattedDate;
                    }

                    html += `
            <li class="${message.ID_USER === <?php echo $_SESSION["id_user"]; ?> ? 'self' : 'other'}">
                <div class="msg">
                    ${message.ID_USER !== <?php echo $_SESSION["id_user"]; ?> ? `<div class="user">${message.FIRST_NAME} ${message.LAST_NAME}</div>` : ''}
                    ${
                        message.CONTENT.startsWith('FILE')
                            ? (() => {
                                  const filePath = `../../assets/chatAssets/${message.CONTENT}`;
                                  const fileExtension = filePath.split('.').pop().toLowerCase();

                                  if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(fileExtension)) {
                                      return `<img src="${filePath}" alt="Image">`;
                                  } else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
                                      return `<video controls> <source src ="${filePath}" type ="video/${fileExtension}"> </video>`;
                } else if (['mp3', 'wav', 'ogg'].includes(fileExtension)) {
                    return `<audio controls><source src="${filePath}" type="audio/${fileExtension}"></audio>`;
                } else if (fileExtension === 'pdf') {
                    return `<iframe src="${filePath}" type="application/pdf"></iframe>`;
                } else {

                    
                    const fileSize = message.file_size;
                    
                    return `
                                          <button onclick="this.querySelector('#LinkForDownload').click()">
                                              <div class="informations">
                                                  <i class="fa-solid fa-file"></i>
                                                  <p>${message.file_path}</p>
                                                  <p>${fileSize}</p>
                                              </div>
                                              <a id="LinkForDownload" href="${filePath}" download="${message.file_path}">
                                                  <i class="fa-regular fa-circle-down fa-shake" style="color: #000000;"></i>
                                              </a>
                                          </button>`;
                }
            })(): message.CONTENT.startsWith('SR') ?
            (() => {
                const filePath = `../../assets/Audio/${message.CONTENT}`;
                const fileExtension = filePath.split('.').pop().toLowerCase();
                return `<audio controls><source src="${filePath}" type="audio/${fileExtension}"></audio>`;
            })() :
            `<p>${message.CONTENT}</p>`
        } 
        
        <time> ${new Date(message.TIMESTAMP).toLocaleTimeString('en-US', {hour12: false, hour: '2-digit', minute: '2-digit'})} </time>
         </div> </li>`;
        });

        document.querySelector('.chat').innerHTML += html;
        document.querySelector('.chat-container').scrollTop = document.querySelector('.chat-container').scrollHeight;

        return {
            firstMessageID,
            lastMessageID
        };
        }


function displayMessages2(messages) {
    let prevDate = null;
    let firstMessageID = null;
    let newLastMessageID = null;
    let html = '';

    messages.forEach((message, index) => {
        if (index === 0) {
            firstMessageID = message.ID_MESSAGE;
        }
        newLastMessageID = message.ID_MESSAGE;

        const currentDate = new Date(message.TIMESTAMP);
        const formattedDate =
            currentDate.toDateString() === new Date().toDateString()
                ? 'Today'
                : currentDate.toDateString() === new Date(Date.now() - 86400000).toDateString()
                ? 'Yesterday'
                : currentDate.toLocaleDateString();

        if (formattedDate !== prevDate) {
            if (prevDate !== null) {
                html += `</ul>`;
            }
            html += `<hr class="hr-text" data-content="${formattedDate}"><ul>`;
            prevDate = formattedDate;
        }

        html += `
            <li id="message-${newLastMessageID}" class="${message.ID_USER === <?php echo $_SESSION["id_user"]; ?> ? 'self' : 'other'}">
                <div class="msg">
                    ${message.ID_USER !== <?php echo $_SESSION["id_user"]; ?> ? `<div class="user">${message.FIRST_NAME} ${message.LAST_NAME}</div>` : ''}
                    ${
                        message.CONTENT.startsWith('FILE')
                            ? (() => {
                                  const filePath = `../../assets/chatAssets/${message.CONTENT}`;
                                  const fileExtension = filePath.split('.').pop().toLowerCase();

                                  if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(fileExtension)) {
                                      return `<img src="${filePath}" alt="Image">`;
                                  } else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
                                      return ` < video controls > < source src = "${filePath}"
                    type = "video/${fileExtension}" > < /video>`;
                              } else if (['mp3', 'wav', 'ogg'].includes(fileExtension)) {
                                  return `<audio controls><source src="${filePath}" type="audio/${fileExtension}"></audio>`;
                              } else if (fileExtension === 'pdf') {
                                  return `<iframe src="${filePath}" type="application/pdf"></iframe>`;
                              } else {

                                  const fileSize = message.file_size;

                                  return `
                                      <button onclick="this.querySelector('#LinkForDownload').click()">
                                          <div class="informations">
                                              <i class="fa-solid fa-file"></i>
                                              <p>${message.file_path}</p>
                                              <p>${fileSize}</p>
                                          </div>
                                          <a id="LinkForDownload" href="${filePath}" download="${message.file_path}">
                                              <i class="fa-regular fa-circle-down fa-shake" style="color: #000000;"></i>
                                          </a>
                                      </button>`;
                              }
                          })()
                        : message.CONTENT.startsWith('SR')
                        ? (() => {
                              const filePath = `../../assets/Audio/${message.CONTENT}`;
                              const fileExtension = filePath.split('.').pop().toLowerCase();
                              return `<audio controls><source src="${filePath}" type="audio/${fileExtension}"></audio>`;
                          })()
                        : `<p>${message.CONTENT}</p>`
                    } 
        
        <time> ${new Date(message.TIMESTAMP).toLocaleTimeString('en-US', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        })} </time>
         </div> </li>`;
    });

    html += `</ul>`;

    document.querySelector('.chat').innerHTML = html + document.querySelector('.chat').innerHTML;
    removeDuplicateHr();

    return {
        firstMessageID,
        newLastMessageID
    };
}



function removeDuplicateHr() {
    const seenDates = new Set();
    const hrElements = document.querySelectorAll('.hr-text');
    hrElements.forEach((hr) => {
        const content = hr.getAttribute('data-content');
        if (seenDates.has(content)) {
            hr.parentNode.removeChild(hr);
        } else {
            seenDates.add(content);
        }
    });
}


        // Assuming `messages` is an array of message objects similar to what you had in PHP


        var firstMessageID;
        var lastMessageID;
        var newLastMessageID;


function fetchMessages() {
    var groupId = document.getElementById('group_id').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getChat.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var messages = response.messages;

            ( { firstMessageID , lastMessageID } = displayMessages(messages));

        }
    };
    xhr.send('group_id=' + groupId);
}

    var currentChatHtml = document.querySelector('.chat').innerHTML; // Variable to store the current chat HTML


        // Start fetching new messages at intervals
        setInterval(fetchNewMessages, 500);

        function fetchNewMessages() {
            var groupId = document.getElementById('group_id').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'getNewChat.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var newChatHtml = xhr.responseText;

                    if (newChatHtml !== currentChatHtml) {
                        var tempDiv = document.createElement('div');
                        tempDiv.innerHTML = newChatHtml;

                        var images = tempDiv.querySelectorAll('img');
                        var loadedImages = 0;
                        var totalImages = images.length;

                        images.forEach(function(img) {
                            img.onload = function() {
                                loadedImages++;
                                if (loadedImages === totalImages) {
                                    // All images have been loaded
                                    document.querySelector('.chat').innerHTML += newChatHtml;

                                    var chatContainer = document.querySelector('.chat-container');
                                    chatContainer.scrollTop = chatContainer.scrollHeight;

                                    // Update the current chat HTML
                                    currentChatHtml = newChatHtml;
                                }
                            };
                        });

                        if (totalImages === 0) {
                            // If there are no images, update the chat immediately
                            document.querySelector('.chat').innerHTML = newChatHtml;

                            var chatContainer = document.querySelector('.chat-container');
                            chatContainer.scrollTop = chatContainer.scrollHeight;

                            // Update the current chat HTML
                            currentChatHtml = newChatHtml;
                        }
                    }
                }
            };
            xhr.send('group_id=' + groupId + 'lastMessageID=' +lastMessageID);
        }



function fetchMoreMessages() {
    var groupId = document.getElementById('group_id').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getMoreChat.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var messages = response.messages;

            // Display the new messages and get the ID of the new last message
            ( { newLastMessageID, firstMessageID } = displayMessages2(messages));
            
            // Fetch the last message element in the new messages
            var lastMessageElement = document.getElementById('message-' + newLastMessageID);
            
            // Scroll to the last message in the new messages
            if (firstMessageID) {
            lastMessageElement.scrollIntoView({  block: 'center' });
        }
    }
};
xhr.send('group_id=' + groupId + '&first_message_id=' + firstMessageID);
}




        document.querySelector('.chat-container').addEventListener('scroll', function() {
            if (this.scrollTop === 0) {
                if (firstMessageID) {
                    fetchMoreMessages();
                }
            }
        });
    </script>

    <script>

        var count = 0;

        var sendMessageForm = document.getElementById('sendMessageForm');
        sendMessageForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var groupId = document.getElementById('group_id').value; // Get the group_id from the hidden input
            var groupId = document.getElementById('group_id').value; // Get the group_id from the hidden input
            var messageContent = document.getElementById('message_content').value; // Get the message content from the input field

            if (messageContent !== '') {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'send_message.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Clear the message input after sending the message
                        document.getElementById('message_content').value = '';
                        fetchNewMessages();
                        updateLastMessages();
                        toggleRecordingButton();

                        count++;
                        console.log(count);
                        if (count > 50){
                            window.location.reload();
                        } 
                    }
                };
                xhr.send('group_id=' + groupId + '&message_content=' + encodeURIComponent(messageContent)); // Send the request with group_id and message_content as parameters
            }
        });


    </script>


    <script>
        // Scroll to the active group
        function scrollToActiveGroup() {
            const activeGroup = document.querySelector('.group .active');
            if (activeGroup) {
                activeGroup.scrollIntoView({
                    block: 'center'
                });
            }
        }

        // Call the function when the page loads
        document.addEventListener('DOMContentLoaded', scrollToActiveGroup);

    </script>

<script src="../../js/Settings.js"></script>


</body>

</html>