<?php
include("includes/includedFiles.php");
?>

<section class="contact-container">
  <div class="contact-wrapper">
    <h2 class="title-animate">Let's Get In Touch</h2>
    <p class="subtitle-animate">Feel free to reach out - I'd love to hear from you!</p>

    <form class="contact-form">
      <div class="form-row">
        <div class="input-group">
          <input type="text" id="name" class="input-field" required>
          <label for="name">Full Name</label>
          <span class="error-message">Full Name is required</span>
        </div>

        <div class="input-group">
          <input type="email" id="email" class="input-field" required>
          <label for="email">Email Address</label>
          <span class="error-message">Please enter a valid email</span>
        </div>
      </div>

      <div class="form-row">
        <div class="input-group">
          <input type="tel" id="phone" class="input-field" required>
          <label for="phone">Phone Number</label>
          <span class="error-message">Phone Number is required</span>
        </div>

        <div class="input-group">
          <input type="text" id="subject" class="input-field" required>
          <label for="subject">Subject</label>
          <span class="error-message">Subject is required</span>
        </div>
      </div>

      <div class="input-group full-width">
        <textarea id="message" class="input-field" rows="5" required></textarea>
        <label for="message">Your Message</label>
        <span class="error-message">Message is required</span>
      </div>

      <button type="submit" class="submit-btn">
        <span class="btn-text">Send Message</span>
        <span class="btn-icon">→</span>
      </button>
    </form>
  </div>
</section>

<style>
.contact-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  /* background: var(--background-color, #1a1a1a); */
}

.contact-wrapper {
  width: 100%;
  max-width: 800px;
  background: var(--card-bg, #242424);
  padding: 3rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.title-animate {
  font-size: 2.5rem;
  color: var(--text-primary, #fff);
  margin-bottom: 0.5rem;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s ease forwards;
}

.subtitle-animate {
  color: var(--text-secondary, #888);
  margin-bottom: 2rem;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s ease forwards 0.2s;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.input-group {
  position: relative;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s ease forwards 0.4s;
}

.input-field {
  width: 100%;
  padding: 1rem;
  border: 2px solid var(--border-color, #333);
  border-radius: 10px;
  background: transparent;
  color: var(--text-primary, #fff);
  font-size: 1rem;
  transition: all 0.3s ease;
}

.input-field:focus {
  /* border-color: var(--accent-color, #FFA500); */
  border-color: var(--accent-color, #fff);
  outline: none;
}

label {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-secondary, #888);
  pointer-events: none;
  transition: all 0.3s ease;
}

.input-field:focus ~ label,
.input-field:not(:placeholder-shown) ~ label {
  top: -0.5rem;
  left: 0.8rem;
  font-size: 0.8rem;
  padding: 0 0.4rem;
  background: var(--card-bg, #242424);
  /* color: var(--accent-color, #FFA500); */
  color: var(--accent-color, #fff);
}

.submit-btn {
  align-self: flex-start;
  padding: 1rem 2rem;
  /* background: var(--accent-color, #FFA500); */
  background: var(--accent-color, #5773ff);
  border: none;
  border-radius: 10px;
  color: #000;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s ease forwards 0.6s;
}

.submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
}

.btn-icon {
  transition: transform 0.3s ease;
}

.submit-btn:hover .btn-icon {
  transform: translateX(5px);
}

.error-message {
  position: absolute;
  bottom: -1.5rem;
  left: 0;
  color: #ff4444;
  font-size: 0.8rem;
  opacity: 0;
  transform: translateY(-10px);
  transition: all 0.3s ease;
}

.input-field.error {
  border-color: #ff4444;
}

.input-field.error + label {
  color: #ff4444;
}

.input-field.error ~ .error-message {
  opacity: 1;
  transform: translateY(0);
}

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 768px) {
  .contact-wrapper {
    padding: 1.5rem;
    margin: 1rem;
    border-radius: 15px;
  }
  
  .title-animate {
    font-size: 1.8rem;
    text-align: center;
  }

  .subtitle-animate {
    font-size: 0.9rem;
    text-align: center;
    margin-bottom: 1.5rem;
  }

  .form-row {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .input-field {
    padding: 0.8rem;
    font-size: 0.9rem;
  }

  .submit-btn {
    width: 100%;
    justify-content: center;
    padding: 0.8rem 1.5rem;
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .contact-container {
    padding: 1rem;
  }

  .contact-wrapper {
    padding: 1.2rem;
  }

  .title-animate {
    font-size: 1.5rem;
  }

  .input-group {
    margin-bottom: 0.5rem;
  }

  .error-message {
    font-size: 0.75rem;
    bottom: -1.2rem;
  }
}
</style>

<script src="https://smtpjs.com/v3/smtp.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.contact-form');
  const inputs = form.querySelectorAll('.input-field');

  // Input validation
  const validateInput = (input) => {
    const value = input.value.trim();
    const isValid = value !== '';
    
    if (input.id === 'email') {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(value);
    }
    
    return isValid;
  };

  // Handle input changes
  inputs.forEach(input => {
    input.addEventListener('input', () => {
      if (validateInput(input)) {
        input.classList.remove('error');
      } else {
        input.classList.add('error');
      }
    });
  });

  // Form submission
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    let isValid = true;
    inputs.forEach(input => {
      if (!validateInput(input)) {
        input.classList.add('error');
        isValid = false;
      }
    });

    if (isValid) {
      const submitBtn = form.querySelector('.submit-btn');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="btn-text">Sending...</span>';

      try {
        // Your email sending logic here
        await Swal.fire({
          title: 'Message Sent!',
          text: 'Thank you for reaching out. I\'ll get back to you soon!',
          icon: 'success',
          background: '#242424',
          color: '#fff',
          // confirmButtonColor: '#FFA500',
          confirmButtonColor: '#5773ff',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          }
        });

        form.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span class="btn-text">Send Message</span><span class="btn-icon">→</span>';
      } catch (error) {
        Swal.fire({
          title: 'Oops...',
          text: 'Something went wrong! Please try again later.',
          icon: 'error',
          background: '#242424',
          color: '#fff',
          // confirmButtonColor: '#FFA500'
          confirmButtonColor: '#5773ff'
        });
        
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span class="btn-text">Send Message</span><span class="btn-icon">→</span>';
      }
    }
  });
});
</script>