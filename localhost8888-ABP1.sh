#!/bin/bash
konsole --nofork -e php -S localhost:8888 &
firefox http://localhost:8888/mid3TagMp3AudioBookP1.php
exit 0
