import React, { useEffect, useState } from "react";
import {
    Box,
    Table,
    Tbody,
    Td,
    Th,
    Thead,
    Tr,
    Input,
    Button,
    Select,
} from "@chakra-ui/react";
import axios from "axios";

const ViewLogs = () => {
    const [logs, setLogs] = useState([]);
    const [category, setCategory] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [currentPage, setCurrentPage] = useState(1);
    const [logsPerPage] = useState(10); // Number of logs per page
    const [totalPages, setTotalPages] = useState(0); // Total number of pages

    useEffect(() => {
        fetchLogs();
    }, [currentPage]);

    const fetchLogs = async (filters = {}) => {
        const response = await axios.get("/api/messages/logs", {
            params: {
                ...filters,
                page: currentPage,
                limit: logsPerPage,
            },
        });
        setLogs(response.data.data);
        setTotalPages(response.data.last_page);
    };

    const handleFilter = () => {
        const filters = {
            category: category || undefined,
            email: email || undefined,
            phone: phone || undefined,
        };

        setCurrentPage(1);
        fetchLogs(filters);
    };

    const paginate = (pageNumber) => setCurrentPage(pageNumber);

    return (
        <Box>
            {/* Filter Inputs */}
            <Box mb="4">
                <Input
                    placeholder="Filter by category"
                    value={category}
                    onChange={(e) => setCategory(e.target.value)}
                    mb="2"
                />
                <Input
                    placeholder="Filter by email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    mb="2"
                />
                <Input
                    placeholder="Filter by phone"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    mb="2"
                />
                <Button onClick={handleFilter} colorScheme="teal">
                    Filter
                </Button>
            </Box>

            {/* Logs Table */}
            <Table variant="simple">
                <Thead>
                    <Tr>
                        <Th>ID</Th>
                        <Th>Category</Th>
                        <Th>Phone</Th>
                        <Th>Email</Th>
                        <Th>Message</Th>
                        <Th>Status</Th>
                        <Th>Channel</Th>
                        <Th>Date</Th>
                    </Tr>
                </Thead>
                <Tbody>
                    {logs.map((log) => (
                        <Tr key={log.id}>
                            <Td>{log.id}</Td>
                            <Td>{log.category.name}</Td>
                            <Td>{log.user.phone}</Td>
                            <Td>{log.user.email}</Td>
                            <Td>{log.message.content}</Td>
                            <Td>{log.status}</Td>
                            <Td>{log.channel.name}</Td>
                            <Td>{new Date(log.created_at).toLocaleString()}</Td>
                        </Tr>
                    ))}
                </Tbody>
            </Table>

            {/* Pagination Controls */}
            <Box mt="4">
                {Array.from({ length: totalPages }, (_, index) => (
                    <Button
                        key={index}
                        onClick={() => paginate(index + 1)}
                        mr="2"
                        isActive={currentPage === index + 1}
                    >
                        {index + 1}
                    </Button>
                ))}
            </Box>
        </Box>
    );
};

export default ViewLogs;
