function postRefreshPage (key, value) {
  var theForm, newInput1;
  // Start by creating a <form>
  theForm = document.createElement('form');
  theForm.action = 'index.php';
  theForm.method = 'get';
  // Next create the <input>s in the form and give them names and values
  newInput1 = document.createElement('input');
  newInput1.type = 'hidden';
  newInput1.name = key;
  newInput1.value = value;
  // Now put everything together...
  theForm.appendChild(newInput1);
  // ...and it to the DOM...
  document.getElementById('hidden_form_container').appendChild(theForm);
  // ...and submit it
  theForm.submit();
}