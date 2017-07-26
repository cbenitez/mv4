<?php

  class model {

    // This method will return data generally from a database table
    // To keep it simple for the post we return some dummy lipsum text
    static function test1data() {
      logger::log("Returning test1data() from database");
      return "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ut nulla ac risus viverra ornare. Nulla consectetur, metus eleifend pharetra posuere, lacus nibh elementum leo, in fermentum lectus lorem in ipsum. Nullam pulvinar purus at erat pharetra volutpat. Pellentesque egestas rutrum lectus, ut rutrum tellus tristique sed. Integer diam est, ornare ac ultricies vel, aliquam non mi. Etiam tempor leo eu lacus tempus sagittis sagittis turpis dictum. Sed leo sapien, pharetra sit amet faucibus et, mollis id nulla. Praesent feugiat mi nec dui scelerisque mollis vehicula magna feugiat. Aliquam erat volutpat. Curabitur quis velit ut nibh rhoncus convallis. Proin mauris nunc, rhoncus vel laoreet vel, aliquet quis nunc. Aenean interdum risus non neque blandit sed adipiscing ipsum mollis. Vivamus enim orci, ultrices at scelerisque vel, laoreet a turpis. Nullam posuere ante sed nisl porta porta aliquam metus suscipit. Fusce enim odio, iaculis at suscipit eget, vestibulum volutpat enim. Nam dictum turpis quis velit posuere in malesuada mi convallis. Donec faucibus, felis id dictum imperdiet, orci tortor tristique neque, vitae lobortis libero tellus sed lorem. Duis tellus magna, commodo eget blandit ut, auctor nec nibh. Maecenas ornare ornare risus nec ultrices. Pellentesque lectus eros, imperdiet ut rhoncus vel, tempus ut nisi.";
    }

    static function test2data() {
      logger::log("Returning test2data() from database");
      return "Vestibulum laoreet nibh sed nulla mollis cursus. Maecenas sodales mauris sit amet ligula euismod a lacinia turpis adipiscing. Nulla gravida porta augue, id adipiscing libero tincidunt ac. Morbi non velit id odio porta tempus id eget massa. Cras nibh purus, gravida sed suscipit ut, tincidunt eu neque. In id est eros, ac sodales orci. Ut lectus augue, feugiat sit amet consectetur id, pharetra quis tellus. Maecenas eget lobortis urna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt eleifend neque. Aenean accumsan orci vitae erat blandit porttitor. Aliquam tristique dolor ac nibh elementum id lacinia diam cursus.";
    }

  }