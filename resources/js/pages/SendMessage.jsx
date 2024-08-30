import React, { useState } from "react";
import {
    Box,
    Button,
    FormControl,
    FormLabel,
    Input,
    Select,
} from "@chakra-ui/react";
import axios from "axios";

const SendMessage = () => {
    const [message, setMessage] = useState("");
    const [category, setCategory] = useState("1");

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post("/api/messages", {
                message,
                category_id: category,
            });
            alert("Message sent successfully!");
        } catch (error) {
            alert("Failed to send message");
        }
    };

    return (
        <Box as="form" onSubmit={handleSubmit}>
            <FormControl mb="4">
                <FormLabel>Message</FormLabel>
                <Input
                    value={message}
                    onChange={(e) => setMessage(e.target.value)}
                />
            </FormControl>
            <FormControl mb="4">
                <FormLabel>Category</FormLabel>
                <Select
                    value={category}
                    onChange={(e) => setCategory(e.target.value)}
                >
                    <option value="1">Sports</option>
                    <option value="2">Finance</option>
                    <option value="3">Movies</option>
                </Select>
            </FormControl>
            <Button type="submit" colorScheme="teal">
                Send Message
            </Button>
        </Box>
    );
};

export default SendMessage;
