import $ from 'jquery'

$(document).ready(function() {
  const { location } = ahr_ga_conf.options;
  const select = document.querySelector(`select[name=${location.name}]`);
  const msg = document.querySelector(`#${location.name}-message`);

  const updateActionDescription = () => {
    msg.innerHTML = (select.value === location.hook_name) ? location.custom_hook_info : location.default_hook_info;
  }

  select.addEventListener('change', updateActionDescription);
  updateActionDescription();
})