function createParticles() {
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'particles';
    document.body.appendChild(particlesContainer);

    // Create more particles for a denser effect
    for (let i = 0; i < 100; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        // Varied sizes for more dynamic look
        const size = Math.random() * 6 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        // Random position across the screen
        particle.style.left = `${Math.random() * 100}%`;
        
        // Random blur effect for depth
        particle.style.filter = `blur(${Math.random() * 2}px)`;
        
        // Random animation duration and delay
        particle.style.animationName = 'float';
        particle.style.animationDuration = `${Math.random() * 10 + 10}s`;
        particle.style.animationDelay = `${Math.random() * 5}s`;
        particle.style.animationIterationCount = 'infinite';
        particle.style.animationTimingFunction = 'ease-in-out';
        
        // Random opacity
        particle.style.opacity = Math.random() * 0.5 + 0.1;
        
        particlesContainer.appendChild(particle);
    }
}

// Create new particles periodically
function refreshParticles() {
    const container = document.querySelector('.particles');
    if (container) {
        container.remove();
    }
    createParticles();
}

// Initial creation
document.addEventListener('DOMContentLoaded', () => {
    createParticles();
    // Refresh particles every 30 seconds for continuous smooth animation
    setInterval(refreshParticles, 30000);
}); 