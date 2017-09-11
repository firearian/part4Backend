<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student Ask the lecturer</title>
    
<!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>     
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <link rel="stylesheet" href="SAsk.css">
</head>

<body>
   
 <!-----------------------------NAVBAR ----------------------->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout ">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"> Ask the lecturer </span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <p id="LoggedInAs"> You are logged in as Darius</p>
          </nav>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="StudentMM.php">Main Menu</a>
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>
        
  <form>    
    <div id="NameContainer">
        <div id="Name">  
            <p>Lecturer name:</p>
        
              <div class="mdl-selectfield mdl-js-selectfield">
                <select class="mdl-selectfield__select" id="professsion1" name="professsion">
                  <option value="option1">Darius</option>
                  <option value="option2">Bernard</option>
                </select>
              </div>
           
            
        </div>
        <br>
    </div>
    
    
    <div id="AnswerContainer">
        <div id="AnswerTitle">  
            <p>Ask question below or chose to upload a file</p>
        </div>
        
        <div id="AnswerSelect">   
            <input type="file" name="QuestionImg" accept="image/*">
        </div>
        
        <div id="AnswerTextBox">
            <textarea rows="15" cols="122"></textarea>
        </div>
    </div>
    
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
      Send
    </button>
    </form>
    
    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>
    
</body>
</html>