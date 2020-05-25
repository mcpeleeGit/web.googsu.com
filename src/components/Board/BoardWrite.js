import React, { Component } from 'react';
import './Board.css';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
export class BoardWrite extends Component {

    render() {
        return (
            <div>
                <Form>
                    <Form.Group controlId="exampleForm.ControlInput1">
                        <Form.Label>Title</Form.Label>
                        <Form.Control type="test" placeholder="title" />
                    </Form.Group>
                    <Form.Group controlId="exampleForm.ControlTextarea1">
                        <Form.Label>Contents</Form.Label>
                        <Form.Control as="textarea" rows="10" />
                    </Form.Group>
                    <p />
                    <div className="div-board-button">
                        <Button variant="outline-primary">Write</Button>{' '}
                    </div>
                </Form>
            </div>
        );
    }

}
