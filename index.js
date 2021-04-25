const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server);
var Web3 = require('web3');
var SerialPort = require("serialport");
var arduino = new SerialPort("COM3",{
    baudRate: 9600
});

var Readline = SerialPort.parsers.Readline;

var Myid = 0;


// web3 = new Web3(new Web3.providers.HttpProvider("http://192.168.100.17:8545"));

web3 = new Web3(new Web3.providers.HttpProvider("http://172.20.10.3:8545"));

 var coinbase = web3.eth.coinbase;
 var balance = web3.eth.getBalance(coinbase);

 console.log(coinbase);
 console.log(balance);
//console.log(web3.eth.coinbase);
var ABI = ([
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "id",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "temp",
				"type": "uint256"
			}
		],
		"name": "HumidityChange",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "id",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "string",
				"name": "name",
				"type": "string"
			}
		],
		"name": "IotAddress",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "id",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "string",
				"name": "ipAddress",
				"type": "string"
			}
		],
		"name": "IpChange",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "id",
				"type": "uint256"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "temp",
				"type": "uint256"
			}
		],
		"name": "TempChange",
		"type": "event"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"name": "IotDeviceToOwner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"name": "ToIot",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": false,
		"inputs": [
			{
				"internalType": "string",
				"name": "_newName",
				"type": "string"
			},
			{
				"internalType": "address",
				"name": "_newIotDevice",
				"type": "address"
			}
		],
		"name": "createIotDevice",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			}
		],
		"name": "getHumidity",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "address",
				"name": "_ownerAddress",
				"type": "address"
			}
		],
		"name": "getIotCount",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_index",
				"type": "uint256"
			}
		],
		"name": "getIotIdByIndex",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			}
		],
		"name": "getIpAddress",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			}
		],
		"name": "getTemp",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			}
		],
		"name": "getTime",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"name": "iotdevice",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "id",
				"type": "uint256"
			},
			{
				"internalType": "string",
				"name": "name",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "IpAddress",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "temp",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "humidity",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "time",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"name": "ownerIotCount",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"name": "ownerToIot",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": false,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "_newHumidity",
				"type": "uint256"
			}
		],
		"name": "setHumidity",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": false,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			},
			{
				"internalType": "string",
				"name": "_newIpAddress",
				"type": "string"
			}
		],
		"name": "setIpAddress",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": false,
		"inputs": [
			{
				"internalType": "uint256",
				"name": "_IotId",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "_newTemp",
				"type": "uint256"
			}
		],
		"name": "setTemp",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	}
]);

// var contractAddress = '0xFDc223537D44628946842e801dFCdb2B5A44fd24';
var contractAddress = '0xcC92dF51413180b3dAbB88A777F497Cff766F99F';

const contractIot = web3.eth.contract(ABI).at(contractAddress);


var temperature = 0;
var humidity = 0;

var parser = new Readline();
arduino.pipe(parser);
parser.on('data',function(data){
    console.log(data);
    var sensors = JSON.parse(data);   
		console.log("updating new temp: ", sensors.temperature);
		temperature = sensors.temperature;
		io.emit('sensors.temperature',temperature);
		contractIot.setTemp(Myid, temperature, {from: "0x80A0F1A600C8D3D8D0CDB14B2f3b3dC4C813A84b"}, function(err, res){if(err){console.log(err)} });

	
		console.log("updating new humidity: ", sensors.humidity);
		humidity = sensors.humidity;
		contractIot.setHumidity(Myid, humidity, {from: "0x80A0F1A600C8D3D8D0CDB14B2f3b3dC4C813A84b"}, function(err, res){});
		io.emit('sensors.humidity',humidity);
});

server.listen(3000,()=>{
	console.log("server is running ....");
});

app.get('/', function(req, res) { //tạo webserver khi truy nhập đường dẫn "/".
    res.sendfile(__dirname + '/index1.html'); // thì mở nội dung ở file index.html lên
});