import React, { Component } from 'react';
import './Board.css';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
export class BoardUpdate extends Component {

    render() {
        return (
            <div>
                <Form>
                    <Form.Group controlId="exampleForm.ControlInput1">
                        <Form.Label>Title</Form.Label>
                        <Form.Control type="test" placeholder="Cras justo odio" />
                    </Form.Group>
                    <Form.Group controlId="exampleForm.ControlTextarea1">
                        <Form.Label>Contents</Form.Label>
                        <Form.Control as="textarea" rows="10" placeholder="React-Bootstrap replaces the Bootstrap JavaScript. Each component has been built from scratch as a true React component, without unneeded dependencies like jQuery.
As one of the oldest React libraries, React-Bootstrap has evolved and grown alongside React, making it an excellent choice as your UI foundation.

Built with compatibility in mind, we embrace our bootstrap core and strive to be compatible with the world's largest UI ecosystem.
By relying entirely on the Bootstrap stylesheet, React-Bootstrap just works with the thousands of Bootstrap themes you already love.

The React component model gives us more control over form and function of each component.
Each component is implemented with accessibility in mind. The result is a set of accessible-by-default components, over what is possible from plain Bootstrap."  />
                    </Form.Group>
                    <p />
                    <div className="div-board-button">
                        <Button variant="outline-primary">Update</Button>{' '}
                    </div>
                </Form>
            </div>
        );
    }

}
