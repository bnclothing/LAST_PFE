<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/help.css">
    <link rel="stylesheet" href="../../css/settings.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/all.css">
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    include("../../includes/help.php");
    ?>

    <div class="container-as">
        <form id="colorForm" action="">
            <div class="row">
                <div class="title">Colors</div>
                <div class="value">
                    <div class="side1">
                        <div class="line">
                            <label for="color">Text Color</label>
                            <div class="input-container">
                                <input type="color" id="color" name="color" value="#ffffff"><br><br>
                            </div>
                        </div>
                        <div class="line">
                            <label for="bgColor">Background</label>
                            <div class="input-container">
                                <input type="color" id="bgColor" name="bgColor" value="#101827">
                                <span style="width: 20%;">OR</span>
                                <input type="file" name="bgImage" id="bgImage" accept="image/*">
                            </div>
                        </div>

                        <div class="btns">
                            <button type="submit"><i class="fa-solid fa-check fa-xl"></i></button>
                            <button type="reset" id="resetBtn"><i class="fa-solid fa-x fa-xl"></i></button>
                        </div>
                    </div>
                    <div class="side2">
                        <div class="screen" id="screen">
                            <p>text goes here</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="title">Language</div>
                <div class="value">
                    <div class="line">
                        <label for="lang">Text Color</label>
                        <div class="input-container">
                            <select name="lang" id="lang">
                                <option value="English">English</option>
                                <option value="Arabic">Arabic</option>
                                <option value="French">French</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('color').addEventListener('input', function() {
            document.getElementById('screen').style.color = this.value;
        });

        document.getElementById('bgColor').addEventListener('input', function() {
            document.getElementById('screen').style.backgroundColor = this.value;
            document.getElementById('screen').style.backgroundImage = 'none'; // Remove background image
            localStorage.removeItem('bgImage'); // Remove background image URL from localStorage
        });

        document.getElementById('bgImage').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    localStorage.setItem('bgImage', e.target.result); // Store background image URL in localStorage
                    document.getElementById('screen').style.backgroundImage = `url('${e.target.result}')`;
                    document.getElementById('screen').style.backgroundSize = 'cover';
                    document.getElementById('screen').style.backgroundPosition = 'center';
                }
                reader.readAsDataURL(file);
            }
        });



        document.getElementById('resetBtn').addEventListener('click', function() {
            document.getElementById('screen').style.backgroundImage = 'none'; // Remove background image
            localStorage.removeItem('bgImage'); // Remove background image URL from localStorage
        });

        document.getElementById('colorForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            // Get color and background image values
            const color = document.getElementById('color').value;
            const bgColor = document.getElementById('bgColor').value;
            const lang = document.getElementById('lang').value;

            // Set localStorage for color and background image
            localStorage.setItem('textColor', color);
            localStorage.setItem('bgColor', bgColor);
            localStorage.setItem('lang', lang);


            // Show a confirmation message
            alert('Settings saved!');

            window.location.reload();
        });

        document.getElementById('resetBtn').addEventListener('click', function() {
            document.getElementById('screen').style.backgroundImage = 'none'; // Remove background image
            localStorage.removeItem('bgImage'); // Remove background image URL from localStorage
            document.getElementById('screen').style.color = '#ffffff'; // Reset text color
            document.getElementById('screen').style.backgroundColor = '#101827'; // Reset background color
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Get saved values from localStorage
            const savedTextColor = localStorage.getItem('textColor');
            const savedBgColor = localStorage.getItem('bgColor');
            const savedBgImage = localStorage.getItem('bgImage');
            const savedLang = localStorage.getItem('lang');

            // Apply saved values to the elements
            document.getElementById('color').value = savedTextColor || '#ffffff';
            document.getElementById('bgColor').value = savedBgColor || '#101827';
            document.getElementById('screen').style.color = savedTextColor || 'initial';
            document.getElementById('screen').style.backgroundColor = savedBgColor || 'initial';
            if (savedBgImage) {
                document.getElementById('screen').style.backgroundImage = `url(${savedBgImage})`;
                document.getElementById('screen').style.backgroundSize = 'cover';
                document.getElementById('screen').style.backgroundPosition = 'center';
            }

            // Set selected language based on saved value
            document.getElementById('lang').value = savedLang || 'English';
        });
    </script>


    <?php
    include("../../includes/scripts.php");
    ?>
</body>

</html>