import React, { Component } from 'react';
import './Board.css';
import ListGroup from 'react-bootstrap/ListGroup';
import Button from 'react-bootstrap/Button';
export class BoardList extends Component {

    render() {
        return (
            <div>
                <h1 id="tabelLabel" >Board List</h1>
                <ListGroup>
                    <ListGroup.Item><a href="/board-read">Cras justo odio</a></ListGroup.Item>
                    <ListGroup.Item><a href="/board-read">Dapibus ac facilisis in</a></ListGroup.Item>
                    <ListGroup.Item><a href="/board-read">Morbi leo risus</a></ListGroup.Item>
                    <ListGroup.Item><a href="/board-read">Porta ac consectetur ac</a></ListGroup.Item>
                    <ListGroup.Item><a href="/board-read">Vestibulum at eros</a></ListGroup.Item>
                </ListGroup>
                <p />
                <div className="div-board-button">
                    <Button href="/board-write" variant="outline-primary">Write</Button>{' '}
                </div>

            </div>
        );
    }

}
