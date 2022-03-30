<?php
$host = "mysql-server";
$user = "root";
$pass = "secret";
$db = "app1";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

//INSERT INTO `mydata` (`savedata`, `used`) VALUES ('myvalue', '0');

$n=30;

$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 

$randomString = ""; 

for ($i = 0; $i < $n; $i++) { 

    $index = rand(0, strlen($characters) - 1); 

    $randomString .= $characters[$index]; 

} 



$mytime = time();
echo time();
echo "</br>";
$value=$mytime;

$mymessage = hash('ripemd160', $value.$randomString."password");



$sql = "INSERT INTO `mydata` (`savedata`, `used`) VALUES ('".$mymessage."', '1');";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

</br>
<br>
</br>
<?php echo $randomString;?> 
<form action="/action_page.php">
  <label for="fname">ID</label><br>

  <input type="text" id="name_id" name="fname" value="ID"><br>
  <label for="lname">time</label><br>
    <input type="text" id="time" name="fname" value=<?php echo "\"".$value."\"";?> ><br>
<label for="fname">randomString</label><br>
  <input type="text" id="rand2" name="fname" value=<?php echo "\"".$randomString."\"";?>>
  </br>
</br>
<label for="fname">public_name</label><br>
  <input type="text" id="messagename" name="lname" value="message"><br><br>
  <label for="lname">sign</label><br>
  <input type="text" id="sighname" name="lname" value="sign"><br><br>
  <input type="submit" value="Submit">
</form>


<head>
  <link
    href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/web3@0.19.0/dist/web3.js"></script>
  
</head>

<div>
  <h3>Sign Typed Data V4</h3>
  <button type="button" id="signTypedDataV4Button">sign typed data v4</button>
  <button onclick="displayMessage();">Click me</button>
</div>

    <script>

    	var myaccount = "";
      function displayMessage(){

    alert("inhere");
    message = <?php echo "\"".$mymessage."\"";?>;
    hash = window.web3.utils.sha3(message);
    alert(hash);
    document.getElementById("messagename").value = hash;
    account  = myaccount;
    document.getElementById("name_id").value = account;
    alert(account);
    window.web3.eth.personal.sign(hash, account, function(error, signature) {
    console.log(signature, error);
    document.getElementById("sighname").value = signature;

  })
}   
      // get reference to button


    </script>



<script>







</script>
</body>



<head>
  <link
    href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css"
    rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>

  
</head>

<body class="h-full">
  <div
    class="
      flex
      w-full
      h-full
      justify-center
      content-center
      items-center
      space-x-4
    "
  >
    <div class="flex flex-col space-y-6">
      <h3 class="text-center">Working with Web3.js!</h3>
      <div class="flex flex-col space-y-2">
        <button
          onclick="loginWithEth()"
          class="
            rounded
            bg-white
            border border-gray-400
            hover:bg-gray-100
            py-2
            px-4
            text-gray-600
            hover:text-gray-700
          "
        >
          Login & Save ETH Address
        </button>
        <p id="userAddress" class="text-gray-600"></p>
        <button
          id="logoutButton"
          onclick="logout()"
          class="hidden text-blue-500 underline"
        >
          Logout
        </button>
      </div>
      <button
        id="getContractInfo"
        onclick="getContractSymbol()"
        class="rounded bg-blue-500 hover:bg-blue-700 py-2 px-4 text-white"
      >
        Get Contract Symbol
      </button>
      <div class="flex flex-col space-y-2"></div>
    </div>
  </div>

  <script>
    window.userAddress = null;
    window.onload = async () => {
      // Init Web3 connected to ETH network
      if (window.ethereum) {
        window.web3 = new Web3(window.ethereum);
      } else {
        alert("No ETH brower extension detected.");
      }

      // Load in Localstore key
      window.userAddress = window.localStorage.getItem("userAddress");
      showAddress();
    };

    // Use this function to turn a 42 character ETH address
    // into an address like 0x345...12345
    function truncateAddress(address) {
      if (!address) {
        return "";
      }
      myaccount=address;
      return `${address}`;
    }

    // Display or remove the users know address on the frontend
    function showAddress() {
      if (!window.userAddress) {
        document.getElementById("userAddress").innerText = "";
        document.getElementById("logoutButton").classList.add("hidden");
        return false;
      }

      document.getElementById(
        "userAddress"
      ).innerText = `ETH Address: ${truncateAddress(window.userAddress)}`;
      document.getElementById("logoutButton").classList.remove("hidden");
    }

    // remove stored user address and reset frontend
    function logout() {
      window.userAddress = null;
      window.localStorage.removeItem("userAddress");
      showAddress();
    }

    // Login with Web3 via Metamasks window.ethereum library
    async function loginWithEth() {
      if (window.Web3) {
        try {
          // We use this since ethereum.enable() is deprecated. This method is not
          // available in Web3JS - so we call it directly from metamasks' library
          const selectedAccount = await window.ethereum
            .request({
              method: "eth_requestAccounts",
            })
            .then((accounts) => accounts[0])
            .catch(() => {
              throw Error("No account selected!");
            });
          window.userAddress = selectedAccount;
          window.localStorage.setItem("userAddress", selectedAccount);
          showAddress();
        } catch (error) {
          console.error(error);
        }
      } else {
        alert("No ETH brower extension detected.");
      }
    }

    // Go to blockchain and get the contract symbol. Keep in mind
    // YOU MUST BE CONNECT TO RINKEBY NETWORK TO USE THIS FUNCTION
    // why -> because this specific contract address is on ethereum.
    // When you click login, just make sure your network is Rinkeby and it will all workout.
    async function getContractSymbol() {
      const CONTRACT_ADDRESS = "0x1A5b30a61CED9B4D9c209E7F1d2fbD38657f8EB1";
      const contract = new window.web3.eth.Contract(
        window.ABI,
        CONTRACT_ADDRESS
      );
      const symbol = await contract.methods
        .symbol()
        .call({ from: window.userAddress });
      alert(`Contract ${CONTRACT_ADDRESS} Symbol: ${symbol}`);
    }

    window.ABI = [
      {
        inputs: [
          {
            internalType: "address",
            name: "_proxyRegistryAddress",
            type: "address",
          },
        ],
        stateMutability: "nonpayable",
        type: "constructor",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: true,
            internalType: "address",
            name: "account",
            type: "address",
          },
        ],
        name: "AddedToAllowlist",
        type: "event",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: true,
            internalType: "address",
            name: "owner",
            type: "address",
          },
          {
            indexed: true,
            internalType: "address",
            name: "approved",
            type: "address",
          },
          {
            indexed: true,
            internalType: "uint256",
            name: "tokenId",
            type: "uint256",
          },
        ],
        name: "Approval",
        type: "event",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: true,
            internalType: "address",
            name: "owner",
            type: "address",
          },
          {
            indexed: true,
            internalType: "address",
            name: "operator",
            type: "address",
          },
          {
            indexed: false,
            internalType: "bool",
            name: "approved",
            type: "bool",
          },
        ],
        name: "ApprovalForAll",
        type: "event",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: false,
            internalType: "address",
            name: "userAddress",
            type: "address",
          },
          {
            indexed: false,
            internalType: "address payable",
            name: "relayerAddress",
            type: "address",
          },
          {
            indexed: false,
            internalType: "bytes",
            name: "functionSignature",
            type: "bytes",
          },
        ],
        name: "MetaTransactionExecuted",
        type: "event",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: true,
            internalType: "address",
            name: "previousOwner",
            type: "address",
          },
          {
            indexed: true,
            internalType: "address",
            name: "newOwner",
            type: "address",
          },
        ],
        name: "OwnershipTransferred",
        type: "event",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: true,
            internalType: "address",
            name: "account",
            type: "address",
          },
        ],
        name: "RemovedFromAllowlist",
        type: "event",
      },
      {
        anonymous: false,
        inputs: [
          {
            indexed: true,
            internalType: "address",
            name: "from",
            type: "address",
          },
          {
            indexed: true,
            internalType: "address",
            name: "to",
            type: "address",
          },
          {
            indexed: true,
            internalType: "uint256",
            name: "tokenId",
            type: "uint256",
          },
        ],
        name: "Transfer",
        type: "event",
      },
      {
        inputs: [],
        name: "ERC712_VERSION",
        outputs: [{ internalType: "string", name: "", type: "string" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "PRICE",
        outputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "RAMPPADDRESS",
        outputs: [{ internalType: "address", name: "", type: "address" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "SUPPLYCAP",
        outputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "_address", type: "address" },
        ],
        name: "addToAllowlist",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "to", type: "address" },
          { internalType: "uint256", name: "tokenId", type: "uint256" },
        ],
        name: "approve",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [{ internalType: "address", name: "owner", type: "address" }],
        name: "balanceOf",
        outputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "baseTokenURI",
        outputs: [{ internalType: "string", name: "", type: "string" }],
        stateMutability: "pure",
        type: "function",
      },
      {
        inputs: [],
        name: "contractURI",
        outputs: [{ internalType: "string", name: "", type: "string" }],
        stateMutability: "pure",
        type: "function",
      },
      {
        inputs: [],
        name: "disableAllowlistOnlyMode",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "enableAllowlistOnlyMode",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "userAddress", type: "address" },
          { internalType: "bytes", name: "functionSignature", type: "bytes" },
          { internalType: "bytes32", name: "sigR", type: "bytes32" },
          { internalType: "bytes32", name: "sigS", type: "bytes32" },
          { internalType: "uint8", name: "sigV", type: "uint8" },
        ],
        name: "executeMetaTransaction",
        outputs: [{ internalType: "bytes", name: "", type: "bytes" }],
        stateMutability: "payable",
        type: "function",
      },
      {
        inputs: [{ internalType: "uint256", name: "tokenId", type: "uint256" }],
        name: "getApproved",
        outputs: [{ internalType: "address", name: "", type: "address" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "getChainId",
        outputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "getDomainSeperator",
        outputs: [{ internalType: "bytes32", name: "", type: "bytes32" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [{ internalType: "address", name: "user", type: "address" }],
        name: "getNonce",
        outputs: [{ internalType: "uint256", name: "nonce", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "_address", type: "address" },
        ],
        name: "isAllowlisted",
        outputs: [{ internalType: "bool", name: "", type: "bool" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "owner", type: "address" },
          { internalType: "address", name: "operator", type: "address" },
        ],
        name: "isApprovedForAll",
        outputs: [{ internalType: "bool", name: "", type: "bool" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [{ internalType: "address", name: "_to", type: "address" }],
        name: "mintTo",
        outputs: [],
        stateMutability: "payable",
        type: "function",
      },
      {
        inputs: [{ internalType: "address", name: "_to", type: "address" }],
        name: "mintToAdmin",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "mintingOpen",
        outputs: [{ internalType: "bool", name: "", type: "bool" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "name",
        outputs: [{ internalType: "string", name: "", type: "string" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "onlyAllowlistMode",
        outputs: [{ internalType: "bool", name: "", type: "bool" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "openMinting",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "owner",
        outputs: [{ internalType: "address", name: "", type: "address" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [{ internalType: "uint256", name: "tokenId", type: "uint256" }],
        name: "ownerOf",
        outputs: [{ internalType: "address", name: "", type: "address" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "payableAddressCount",
        outputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        name: "payableAddresses",
        outputs: [{ internalType: "address", name: "", type: "address" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        name: "payableFees",
        outputs: [{ internalType: "uint256", name: "", type: "uint256" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "_address", type: "address" },
        ],
        name: "removeFromAllowlist",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "renounceOwnership",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "from", type: "address" },
          { internalType: "address", name: "to", type: "address" },
          { internalType: "uint256", name: "tokenId", type: "uint256" },
        ],
        name: "safeTransferFrom",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "from", type: "address" },
          { internalType: "address", name: "to", type: "address" },
          { internalType: "uint256", name: "tokenId", type: "uint256" },
          { internalType: "bytes", name: "_data", type: "bytes" },
        ],
        name: "safeTransferFrom",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "operator", type: "address" },
          { internalType: "bool", name: "approved", type: "bool" },
        ],
        name: "setApprovalForAll",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "uint256", name: "_feeInWei", type: "uint256" },
        ],
        name: "setPrice",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "stopMinting",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "bytes4", name: "interfaceId", type: "bytes4" },
        ],
        name: "supportsInterface",
        outputs: [{ internalType: "bool", name: "", type: "bool" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [],
        name: "symbol",
        outputs: [{ internalType: "string", name: "", type: "string" }],
        stateMutability: "view",
        type: "function",
      },
      {
        inputs: [
          { internalType: "uint256", name: "_tokenId", type: "uint256" },
        ],
        name: "tokenURI",
        outputs: [{ internalType: "string", name: "", type: "string" }],
        stateMutability: "pure",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "from", type: "address" },
          { internalType: "address", name: "to", type: "address" },
          { internalType: "uint256", name: "tokenId", type: "uint256" },
        ],
        name: "transferFrom",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [
          { internalType: "address", name: "newOwner", type: "address" },
        ],
        name: "transferOwnership",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "withdrawAll",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
      {
        inputs: [],
        name: "withdrawAllRampp",
        outputs: [],
        stateMutability: "nonpayable",
        type: "function",
      },
    ];
  </script>
</body>

