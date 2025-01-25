<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/materialize-css/dist/css/materialize.min.css">
</head>
<body>
  <div id="app" class="container">
    <h3 class="center-align">Login</h3>
    <form @submit.prevent="handleLogin">
      <div class="input-field">
        <input type="text" id="username" v-model="username" required>
        <label for="username">Username</label>
      </div>
      <div class="input-field">
        <input type="password" id="password" v-model="password" required>
        <label for="password">Password</label>
      </div>
      <div class="center-align">
        <button class="btn waves-effect waves-light" type="submit">Login</button>
      </div>
    </form>
    <div v-if="errorMessage" class="red-text center-align">
      {{ errorMessage }}
    </div>
  </div>

  <script>
    const app = Vue.createApp({
      data() {
        return {
          username: '',
          password: '',
          errorMessage: ''
        };
      },
      methods: {
        async handleLogin() {
          try {
            const response = await axios.post('login_handler.php', {
              username: this.username,
              password: this.password
            });
            if (response.data.success) {
              alert('Login successful!');
            } else {
              this.errorMessage = response.data.message;
            }
          } catch (error) {
            this.errorMessage = 'An error occurred. Please try again.';
          }
        }
      }
    });

    app.mount('#app');
  </script>
</body>
</html>
