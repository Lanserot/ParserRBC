CREATE TABLE shortNews(
id_shortNews int(11) auto_increment primary key,
id_newsRBC text(3000),
title text(3000),
original_link text(3000)
);

CREATE TABLE longNews(
id_longNews int(11) auto_increment primary key,
id_shortNews int(11),
    FOREIGN KEY (id_shortNews) REFERENCES shortNews(id_shortNews),
title text(3000),
overview text(3000),
img text(3000)

);
CREATE TABLE description(
id_desc int(11) auto_increment primary key,
id_longNews int(11),
    FOREIGN KEY (id_longNews) REFERENCES longNews(id_longNews),
description text(3000)
);