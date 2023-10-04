function setImageAsBackground(inputId, containerId) {
  const imageInput = document.getElementById(inputId);
  const imageContainer = document.getElementById(containerId);

  imageInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file)
    {
      const reader = new FileReader();

      reader.onload = function (e)
      {
        const imageUrl = e.target.result;
        imageContainer.style.backgroundImage = `url(${imageUrl})`;
      };

      reader.readAsDataURL(file);
    }
    else
    {
      imageContainer.style.backgroundImage = 'none';
    }
  });
}

setImageAsBackground('imageInput0', 'imageContainer0');
setImageAsBackground('imageInput1', 'imageContainer1');
setImageAsBackground('imageInput2', 'imageContainer2');
setImageAsBackground('imageInput3', 'imageContainer3');
setImageAsBackground('imageInput4', 'imageContainer4');
setImageAsBackground('imageInput5', 'imageContainer5');

/*-------------------------------------------*/
$(document).ready(function()
  {
    $('#information').submit(function(e)
      {
        e.preventDefault();
        $.ajax({
          url: 'file.php',
          data: $(this).serialize(),
          method: 'POST',
          success: function(resp)
          {
            $('#response').html('! تم حفظ المعلومات بنجاح');
          },
        });
      });
  });

const button = document.getElementById("save");
const elem = document.getElementById("response");

button.addEventListener("click", function()
  {
    elem.classList.toggle("hidden");
  });
