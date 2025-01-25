<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage User Credentials</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/materialize-css/dist/css/materialize.min.css">
</head>
<body>
  <div id="app" class="container">
    <h3 class="center-align">Manage User Credentials</h3>

    <!-- User Table -->
    <div class="card" v-if="users.length">
      <table class="highlight">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>
              <input
                v-if="editUserId === user.id"
                type="text"
                v-model="editableUsername"
              />
              <span v-else>{{ user.username }}</span>
            </td>
            <td>
              <input
                v-if="editUserId === user.id"
                type="text"
                v-model="editablePassword"
              />
              <span v-else>{{ user.password }}</span>
            </td>
            <td>
              <button class="btn-small blue" @click="startEditing(user)" v-if="editUserId !== user.id">
                Edit
              </button>
              <button class="btn-small green" @click="saveUser(user)" v-if="editUserId === user.id">
                Save
              </button>
              <button class="btn-small red" @click="cancelEditing()" v-if="editUserId === user.id">
                Cancel
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="center-align">
      <p>No users found.</p>
    </div>
  </div>

  <script>
    const app = Vue.createApp({
      data() {
        return {
          users: [], // To store fetched user data
          editUserId: null, // Tracks which user's row is being edited
          editableUsername: '',
          editablePassword: ''
        };
      },
      created() {
        this.fetchUsers();
      },
      methods: {
        async fetchUsers() {
          try {
            const response = await axios.get('fetch_users.php');
            if (response.data.success) {
              this.users = response.data.users;
            } else {
              alert(response.data.message);
            }
          } catch (error) {
            console.error("Error fetching users:", error);
          }
        },
        startEditing(user) {
          this.editUserId = user.id;
          this.editableUsername = user.username;
          this.editablePassword = user.password;
        },
        async saveUser(user) {
          try {
            const response = await axios.post('update_user.php', {
              id: user.id,
              username: this.editableUsername,
              password: this.editablePassword
            });
            if (response.data.success) {
              alert('User updated successfully!');
              this.fetchUsers(); // Refresh the table
              this.cancelEditing();
            } else {
              alert(response.data.message);
            }
          } catch (error) {
            console.error("Error updating user:", error);
          }
        },
        cancelEditing() {
          this.editUserId = null;
          this.editableUsername = '';
          this.editablePassword = '';
        }
      }
    });

    app.mount('#app');
  </script>
</body>
</html>
