function ColorCode() {
    var makingColorCode = '0123456789ABCDEF';
    var finalCode = '#';
    for (var counter = 0; counter < 6; counter++) {
       finalCode =finalCode+ makingColorCode[Math.floor(Math.random() * 16)];
    }
    return finalCode;
 }
 //Function calling on button click.
//  function getRandomColor() {
    $(".avatar_grande").css("background-color", ColorCode());
//  }