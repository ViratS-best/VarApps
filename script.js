const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signInForm = document.getElementById('signIn');
const signUpForm = document.getElementById('signup');

signInButton.addEventListener('click', function(){
    signInForm.style.display = 'block';
    signUpForm.style.display = 'none';
})
signUpButton.addEventListener('click', function(){
    signInForm.style.display = 'none';
    signUpForm.style.display = 'block';
});
//This code toggles the visibility of the sign-in and sign-up forms when the respective buttons are clicked.