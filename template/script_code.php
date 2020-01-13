<script>
  $('#link').on('click', function(event) {
    event.preventDefault();
    $('#link').fadeOut(400);
    setTimeout(function() {
        $('#before-load').fadeIn()
        setTimeout(function() {
            $('#before-load').fadeOut(400, function () {
                $('#form').fadeIn()
            })
        }, 3000);
    }, 400)
  });

  // $('.form-step0').on('click', function (event) {
  //   event.preventDefault();
  //
  //   $('.form-step0').fadeOut(0);
  //   $('.form-step1').fadeIn(300);
  //   return false;
  // });
  //
  //
  function quality_show() {
    var q = $('.quality');
    $('.quality').animate({'opacity': '1'}, 200);
    $('.form-step0 .quality').animate({'opacity': '1'}, 200);
    setTimeout(() => {
      $('.quality span').eq(1).addClass('blink');
      $('.form-step0 .quality span').eq(1).addClass('blink');
    }, 400)
  }

  $(document).ready(function () {
    $('.player__progress-load').css('width', '0%');

    var progress = $('.player__progress-load'),
      duration = 1700,
      step = 7;

    progress.animate({'width': step + '%'});

    setTimeout(function () {
      progress.animate({'width': (step * 2) + '%'});

      setTimeout(function () {
        progress.animate({'width': (step * 3) + '%'});
        $('.quality').show();

        setTimeout(() => {
          quality_show();
        }, 300)

      }, duration / 1.5);

    }, duration / 3);
  });
</script>