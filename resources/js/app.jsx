import React, { useState } from "react";
import ReactDOM from "react-dom/client";
import { ChakraProvider, Box, Flex } from "@chakra-ui/react";
import Sidebar from "./components/Sidebar";
import SendMessage from "./pages/SendMessage";
import ViewLogs from "./pages/ViewLogs";

function App() {
    const [currentPage, setCurrentPage] = useState("sendMessage"); // default page

    const renderPage = () => {
        switch (currentPage) {
            case "sendMessage":
                return <SendMessage />;
            case "viewLogs":
                return <ViewLogs />;
            default:
                return <SendMessage />;
        }
    };

    return (
        <ChakraProvider>
            <Flex minHeight="100vh">
                {/* Sidebar should have a fixed width */}
                <Box width="200px">
                    <Sidebar setCurrentPage={setCurrentPage} />
                </Box>
                {/* Main content should take the remaining space */}
                <Box flex="1" p="4" marginLeft="200px">
                    {renderPage()}
                </Box>
            </Flex>
        </ChakraProvider>
    );
}

ReactDOM.createRoot(document.getElementById("app")).render(<App />);
