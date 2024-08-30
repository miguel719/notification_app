import React from "react";
import { Box, VStack, Button } from "@chakra-ui/react";

const Sidebar = ({ setCurrentPage }) => {
    return (
        <Box
            as="nav"
            width="200px"
            bg="gray.100"
            p="4"
            height="100vh"
            position="fixed" // Ensures the sidebar is always fixed to the left
            left="0"
            top="0"
        >
            <VStack spacing="4" align="flex-start">
                <Button
                    variant="link"
                    onClick={() => setCurrentPage("sendMessage")}
                >
                    Send Message
                </Button>
                <Button
                    variant="link"
                    onClick={() => setCurrentPage("viewLogs")}
                >
                    View Logs
                </Button>
            </VStack>
        </Box>
    );
};

export default Sidebar;
