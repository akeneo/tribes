function get_gravatar(email) {
  return ' https://s.gravatar.com/avatar/' + md5(email.trim());
}
