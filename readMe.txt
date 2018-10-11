Design Notes for Naughts and Crosses

The game of Naughts and crosses is a simplistic example of the game with a PHP server for most of the calculations (including a computer player) and a simply HTML, CSS, JavaScript interface to support the player.

Game Loading.
	The game itself should be loaded via Index.html which will call the downstream PHP scripts to load it's content data.

PHP Server.
Control of the ‘game’ is centrally controlled by a text file in the directory ‘gameData’.
Each game has it’s own ‘name’, which allows the server to control the game and be persistant with regards to it’s name.
A computer player will randomly select an item for each possible move.
WebBrowser Interface
Simple pictures are provided to create a simple interface for the user with the naughts and crosses game interface.
A simple look up is made in the browser to display a message to the user and indicate if a game has been completed or not. Once completed, a message is displayed to inform the user.
Each image is clickable and will send request to the server to deduce if the next requested move can be made. The result is then automatically updated on the screen with for the user to see.

Game Information.
	On the right handside the game information is automatically updated, this includes a current listing of all of the individual games played, summary for the result and counter information for each individual game.

Updates/Count summary details are automatically collected from local JSON files stored in the 'gameData' folder.

