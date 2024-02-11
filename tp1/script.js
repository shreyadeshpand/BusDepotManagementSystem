document.addEventListener('DOMContentLoaded', function() {
    const loginLink = document.getElementById('login-link');
    
    loginLink.addEventListener('click', function(event) {
        event.preventDefault();
        showLoginOptions();
    });
});
const backgroundImageUrl = 'url("mainbg.jpg")'; // Replace 'background.jpg' with the path to your background image

function showLoginOptions() {
    // Set the background image for the body element
    document.body.style.backgroundImage = backgroundImageUrl;

    const contentSection = document.getElementById('welcome-section');
    contentSection.innerHTML = `
        <div class="login-section">
            <div class="login-box">
                <h2>Login</h2>
                <p>Choose your role:</p>
                <button class="conductor-login">Conductor Login</button>
                <button class="controller-login">Controller Login</button>
            </div>
        </div>
    `;

    const conductorLoginButton = document.querySelector('.conductor-login');
    const controllerLoginButton = document.querySelector('.controller-login');

    conductorLoginButton.addEventListener('click', function() {
        // Redirect to conductor login page or handle logic
        window.location.href = 'conductor_login.php';
    });

    controllerLoginButton.addEventListener('click', function() {
        // Redirect to controller login page or handle logic
        window.location.href = 'login.php';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize GSAP animation timeline
    const tl = gsap.timeline({ repeat: -1 });

    // Select bus elements
    const buses = document.querySelectorAll('.bus');

    // Animate buses
    buses.forEach((bus, index) => {
        const startPosition = -100 - (index * 200); // Adjust the starting position
        tl.to(bus, {
            x: '100%',
            duration: 10, // Adjust the animation duration as needed
            ease: 'linear',
            delay: index * 2, // Delay each bus to create a staggered effect
            onComplete: () => {
                bus.style.transform = `translateX(${startPosition}px)`;
            }
        });
    });
});
