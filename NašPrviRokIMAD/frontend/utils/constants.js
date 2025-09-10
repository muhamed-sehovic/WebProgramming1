var Constants = {
  get_api_base_url: function () {
    if(location.hostname == 'localhost'){
      return "http://localhost/web-programming-final/backend/rest";
    } else {
      return "";
    }
  }
};